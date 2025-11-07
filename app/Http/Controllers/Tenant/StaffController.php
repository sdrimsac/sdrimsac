<?php

namespace App\Http\Controllers\Tenant;

use App\CoreFacturalo\Requests\Inputs\Functions;
use App\Exports\CreditListExport;
use App\Exports\StaffWorkerExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\CreditListCollection;
use App\Http\Resources\Tenant\CreditListPersonCollection;
use App\Http\Resources\Tenant\StaffPersonCollection;
use App\Http\Resources\Tenant\StaffPersonWorkerCollection;
use App\Imports\PersonWorkerImport;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\CreditList;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\InventoryKardex;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\Payment;
use App\Models\Tenant\Person;
use App\Models\Tenant\PersonAttendance;
use App\Models\Tenant\Series;
use App\Models\Tenant\User;
use App\Models\Tenant\Warehouse;
use App\Models\Tenant\WorkerAdvance;
use App\Models\Tenant\WorkerDailySummari;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\OrdenItem;
use Modules\Restaurant\Models\Table;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Illuminate\Support\Facades\Log;
use Modules\Restobar\Events\OrdenEvent;
use Modules\Restobar\Events\PrintEvent;
use Modules\Restobar\Models\Area;
use Modules\Restobar\Models\Food;
use Maatwebsite\Excel\Excel;
use Modules\Restobar\Models\OrderItemDetail;

class StaffController extends Controller
{
    public function download(Request $request)
    {
        $company = Company::first();
        $records = $this->getData($request)->get();
        $person = Person::find($request->person_id);
        return (new CreditListExport)
            ->records($records)
            ->person($person)
            ->company($company)
            ->download('Lista_de_credito_' . Carbon::now() . '.xlsx');
    }

    public function adelanto(Request $request)
    {

        $person_id = $request->input('person_id');
        $amount = $request->input('amount');
        $method = $request->input('method');
        $date_time_advances = $request->input('date_time_advances');

        $create = WorkerAdvance::create([
            'person_id' => $person_id,
            'amount' => $amount,
            'method' => $method,
            'date_time_advance' => $date_time_advances ?? now()
        ]);

        return response()->json([
            'success' => true,
            'data' => $create
        ]);
    }

    public function importPerson(Request $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '2048M');
        if ($request->hasFile('file')) {
            try {
                $import = new PersonWorkerImport();
                $import->import($request->file('file'), null, Excel::XLSX);
                $data = $import->getData();
                $errors = $import->getErrors();
                return [
                    'success' => true,
                    'message' =>  __('app.actions.upload.success'),
                    'data' => $data,
                    'errors' => $errors
                ];
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' =>  $e->getMessage()
                ];
            }
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }

    public function receipt($id)
    {
        $credit_list = CreditList::find($id);
        $customer = $credit_list->customer;
        $user = $credit_list->seller;
        $orden = $credit_list->orden;
        $total = $orden->getTotal();
        $observation = $credit_list->observation;
        $company = Company::first();
        $count_items = $orden->orden_items->count();


        $height = 10  * 30;
        if ($count_items > 8) {
            $height = $count_items * 30;
        }
        try {
            $pdf = PDF::loadView('restaurant::credit_list.receipt', compact(
                "credit_list",
                "customer",
                "observation",
                "user",
                "orden",
                "total",
                "company",
            ))
                ->setPaper(array(0, 0, 249.45, $height));
        } catch (Exception $e) {
            return ['m' => $e->getMessage()];
        }

        return $pdf->stream('pdf_file.pdf');
    }
    public function recordByPersonToPay(Request $request)
    {
        $request['paid'] = "0";
        $orden_items = $this->getData($request);
        $records = $orden_items->get();
        return [
            'success' => true,
            'records' => $records,
        ];
    }
    public function recordByPersonTotal(Request $request)
    {
        try {
            $data = $this->getData($request);
            // Verificar si $data es un objeto y obtener los resultados
            if (is_object($data)) {
                // Realizar las operaciones necesarias con los resultados
                $total = $data->get()->sum(function ($row) {
                    return $row->quantity * $row->price;
                });

                return [
                    'success' => true,
                    'total' => $total,
                ];
            } else {
                throw new \Exception('La función getData() no devolvió un objeto válido.');
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function generarResumenAsistencias(Request $request)
    {
        $month = $request->input('month', now()->format('m'));
        $year = $request->input('year', now()->format('Y'));

        $empleados = Person::where('is_staff', true)->get();
        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfDay();
        $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth()->endOfDay()->addDay();

        foreach ($empleados as $empleado) {

            $registros = PersonAttendance::where('person_id', $empleado->id)
                ->where(function ($q) use ($startOfMonth, $endOfMonth) {
                    $q->whereBetween('date_time_attendance', [$startOfMonth->toDateTimeString(), $endOfMonth->toDateTimeString()])
                        ->orWhereBetween(DB::raw("CONCAT(date_attendance, ' ', COALESCE(time_attendance, '00:00:00'))"), [$startOfMonth->toDateTimeString(), $endOfMonth->toDateTimeString()]);
                })
                ->orderBy('date_time_attendance')
                ->get();

            // Construir lista con Carbon, tipo y registro original
            $marks = $registros->map(function ($r) {
                if (!empty($r->date_time_attendance)) {
                    $dt = Carbon::parse($r->date_time_attendance);
                } elseif (!empty($r->time_attendance) && !empty($r->date_attendance)) {
                    $dt = Carbon::parse($r->date_attendance . ' ' . $r->time_attendance);
                } else {
                    return null;
                }
                return [
                    'dt' => $dt,
                    'type' => isset($r->type) ? strtolower($r->type) : null,
                    'raw' => $r,
                ];
            })->filter()->values();

            // Eliminar duplicados cercanos (misma marca repetida)
            $filtered = [];
            foreach ($marks as $m) {
                if (empty($filtered)) {
                    $filtered[] = $m;
                    continue;
                }
                $last = end($filtered);
                $diffSeconds = $last['dt']->diffInSeconds($m['dt']);
                // si la diferencia es menor o igual a 5 segundos consideramos duplicado
                if ($diffSeconds <= 5 && $last['type'] === $m['type']) {
                    // omitimos duplicado
                    continue;
                }
                $filtered[] = $m;
            }

            $pairsByDate = [];
            $unpairedByDate = [];

            // Emparejar buscando preferentemente un INGRESO seguido de SALIDA
            $i = 0;
            $count = count($filtered);
            while ($i < $count) {
                $start = $filtered[$i];

                // buscar siguiente marca que sea salida o al menos distinta a la actual
                $end = null;
                for ($j = $i + 1; $j < $count; $j++) {
                    // preferimos emparejar ingreso->salida
                    if ($start['type'] && strpos($start['type'], 'ing') !== false) {
                        if (isset($filtered[$j]['type']) && strpos($filtered[$j]['type'], 'sal') !== false) {
                            $end = $filtered[$j];
                            $i = $j + 1;
                            break;
                        }
                    } else {
                        // si start no es ingreso, aceptamos la siguiente marca distinta
                        $end = $filtered[$j];
                        $i = $j + 1;
                        break;
                    }
                }

                if ($end === null) {
                    // no hay pareja -> registramos un par con exit null
                    $dateKey = $start['dt']->toDateString();
                    $unpairedByDate[$dateKey] = true;
                    if (!isset($pairsByDate[$dateKey])) {
                        $pairsByDate[$dateKey] = ['minutes' => 0, 'pairs' => []];
                    }
                    $pairsByDate[$dateKey]['pairs'][] = [
                        'entrance' => $start['dt']->format('H:i:s'),
                        'exit' => null,
                        'minutes' => 0,
                        'exit_date' => null,
                    ];
                    // avanzar un paso
                    $i++;
                    continue;
                }

                // Asegurar que end es posterior a start (manejo turno nocturno)
                $endDt = $end['dt'];
                $startDt = $start['dt'];
                if ($endDt->lt($startDt)) {
                    $endDt = $endDt->copy()->addDay();
                }

                $dateKey = $startDt->toDateString();
                if (!isset($pairsByDate[$dateKey])) {
                    $pairsByDate[$dateKey] = ['minutes' => 0, 'pairs' => []];
                }
                $minutes = $startDt->diffInMinutes($endDt);
                $pairsByDate[$dateKey]['minutes'] += $minutes;
                $pairsByDate[$dateKey]['pairs'][] = [
                    'entrance' => $startDt->format('H:i:s'),
                    'exit' => $endDt->format('H:i:s'),
                    'minutes' => $minutes,
                    'exit_date' => $endDt->toDateString(),
                ];
            }

            // Guardar/actualizar resumen diario por cada fecha calculada

            foreach ($pairsByDate as $fecha => $data) {
                $workedMinutes = $data['minutes'];
                $horasTrabajadas = $workedMinutes / 60;

                // obtener pares para este dia
                $pairs_array = $data['pairs'] ?? [];

                // fecha de salida: usamos la exit_date del último par si existe
                $fecha_salida = $fecha;
                if (!empty($pairs_array)) {
                    $lastPair = end($pairs_array);
                    if (!empty($lastPair['exit_date'])) {
                        $fecha_salida = $lastPair['exit_date'];
                    }
                }

                $horasExtras = max(0, $horasTrabajadas - 8);

                // Obtener salario mensual: soporta atributos `base_salary` o `base-salary`.
                // Cast a float para evitar problemas con strings vacíos o null.
                $monthlySalary = 0.0;
                if (isset($empleado->base_salary)) {
                    $monthlySalary = (float) $empleado->base_salary;
                } elseif (isset($empleado->{'base-salary'})) {
                    $monthlySalary = (float) $empleado->{'base-salary'};
                } elseif (isset($empleado->salary)) {
                    // fallback por si se usa otro nombre
                    $monthlySalary = (float) $empleado->salary;
                }

                // Hora base: salario mensual dividido por 30 días y 8 horas diarias
                $horaBase = $monthlySalary / 30 / 8;

                $montoExtra = 0;
                // Solo calcular si hay horas extras y la hora base es mayor a 0
                if ($horasExtras > 0 && $horaBase > 0) {
                    // Primeras 2 horas con recargo 25%, siguientes con 35%
                    if ($horasExtras <= 2) {
                        $montoExtra = $horasExtras * $horaBase * 1.25;
                    } else {
                        $montoExtra = (2 * $horaBase * 1.25) + (($horasExtras - 2) * $horaBase * 1.35);
                    }
                }

                $falta = ($workedMinutes == 0) || (!empty($unpairedByDate[$fecha]));

                WorkerDailySummari::updateOrCreate(
                    [
                        'person_id' => $empleado->id,
                        'date_daily' => $fecha
                    ],
                    [
                        // guardamos los pares para que la UI muestre intervalos separados
                        'pairs' => $pairs_array,
                        'entrance' => null,
                        'exit' => null,
                        'horas_trabajadas' => round($horasTrabajadas, 2),
                        'overtime' => round($horasExtras, 2),
                        'amount_extra' => round($montoExtra, 2),
                        'lack' => $falta,
                        'date_end_daily' => $fecha_salida,
                    ]
                );
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Resumen diario generado correctamente'
        ]);
    }

    public function getRecords(Request $request)
    {
        $query = WorkerDailySummari::with('person')
            ->whereHas('person', function ($q) {
                $q->where('is_staff', true);
            });

        if ($request->filled('date')) {
            $query->where('date_daily', $request->date);
        }

        if ($request->filled('date_day')) {
            $query->where('date_daily', $request->date_day);
        }

        if ($request->filled('person_id')) {
            $query->where('person_id', $request->person_id);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('date_daily', [$request->from_date, $request->to_date]);
        }

        $records = $query->orderBy('date_daily', 'desc');

        //return StaffPersonWorkerCollection::collection($records);
        return $records;
        //return new StaffPersonWorkerCollection($records);
    }

    public function recordsWorker(Request $request)
    {
        $records = $this->getRecords($request);

        return new StaffPersonWorkerCollection($records->paginate(20));
    }

    public function ExportExcel(Request $request)
    {
        $company = Company::first();
        $records = $this->getRecords($request)->get();
        /* $person = Person::find($request->person_id); */
        return (new StaffWorkerExport)
            ->records($records)
            /* ->person($person) */
            ->company($company)
            ->download('Lista_de_personal_' . Carbon::now() . '.xlsx');
    }

    public function recordByPerson(Request $request)
    {

        $ordens = $this->getData($request);
        $ordens = $ordens->orderBy('date', 'asc');
        return new StaffPersonCollection($ordens->get());
    }
    public function staff_report_index(Request $request)
    {

        return view('tenant.staff.index');
    }

    private function updateStock($item_id, $quantity, $warehouse_id)
    {

        // $inventory_configuration = InventoryConfiguration::firstOrFail();
        $configuration = Configuration::firstOrFail();
        if ($configuration->college) {

            $item_warehouse = ItemWarehouse::where('item_id', $item_id)->first();
            if (!isset($item_warehouse)) {
                $item_warehouse = ItemWarehouse::firstOrNew(['item_id' => $item_id, 'warehouse_id' => $warehouse_id]);
            }
        } else {

            $item_warehouse = ItemWarehouse::firstOrNew(['item_id' => $item_id, 'warehouse_id' => $warehouse_id]);
        }
        //$item=Item::findOrFail($item_id);
        //     $item->stock=$item_warehouse->stock + $quantity;
        $item_warehouse->stock = $item_warehouse->stock + $quantity;
        if ($quantity < 0 && $item_warehouse->item->unit_type_id !== 'ZZ') {
            if (($configuration->sales_stock) && ($item_warehouse->stock < 0)) {

                throw new Exception("El producto {$item_warehouse->item->description} no tiene suficiente stock!");
            }
        }
        $item_warehouse->save();
        // $item-save();
    }
    function findWarehouse()
    {
        $warehouse = Warehouse::where('establishment_id', auth()->user()->establishment_id)->first();
        if (!$warehouse) {
            $warehouse = Warehouse::create([
                'description' => 'Almacén',
                'establishment_id' => auth()->user()->establishment_id,
            ]);
        }
        return $warehouse;
    }
    function createInventoryKardex($item_id, $quantity, $warehouse_id, $credit_list)
    {
        InventoryKardex::create([
            'inventory_kardexable_id' => $credit_list->id,
            'inventory_kardexable_type' => 'App\Models\Tenant\CreditList',
            'item_id' => $item_id,
            'date_of_issue' => date('Y-m-d'),
            'warehouse_id' => $warehouse_id,
            'quantity' => $quantity,
            'type' => 'output',
            'user_id' => isset(auth()->user()->id) ? auth()->user()->id : null,
        ]);
    }
    function update_stock($credit_list)
    {
        $orden = Orden::find($credit_list->orden_id);
        $items = $orden->orden_items;
        $warehouse = $this->findWarehouse();
        foreach ($items as $orden_item) {
            $food_id = $orden_item->food_id;
            $quantity = $orden_item->quantity * -1;
            $food = Food::find($food_id);
            $item_id = $food->item_id;
            $item = Item::find($item_id);
            if ($item->unit_type_id  !== 'ZZ') {
                if (!$item->is_set && !$item->promotion_items) {

                    $this->createInventoryKardex($item_id, $quantity, $warehouse->id, $credit_list);
                    $this->updateStock($item_id, $quantity, $warehouse->id);
                } else {
                }
            }
        }
    }

    public function send_credit(Request $request)
    {
        $configuration = Configuration::firstOrFail();
        $cash_id = $request->cash_id;
        try {
            DB::beginTransaction();
            $customer_id = $request->customer_id;
            $ref = $request->ref;
            $customer = Person::find($customer_id);
            $customer_name = $customer->name;
            $items = $request->items;
            $user_id = auth()->id();
            $table_caja_id = Table::get_caja();
            $table_caja = Table::find($table_caja_id);
            $table_caja->status_table_id = 2;
            $table_caja->save();
            $status_orden_id = 1;
            $orden = Orden::create([
                'table_id' => $table_caja_id,
                'status_orden_id' => $status_orden_id,
                'date' => date('Y-m-d'),
                'ref' => $customer_name . ' - ' . $ref,
            ]);
            $orden_items_ids = [];
            $orden_items_ids_for_kitchen = [];
            /* foreach ($items as $item) {
                $orden_item = new OrdenItem;
                $orden_item->food_id = $item['food']['id'];
                $orden_item->observations = $item['observation'] ?? '-';
                $orden_item->quantity = $item['quantity'];
                $orden_item->unit_type_id = Functions::valueKeyInArray($item, 'type_id', null);
                $orden_item->price = $item['price'];
                $orden_item->user_id = $user_id;
                $orden_item->orden_id = $orden->id;
                $orden_item->to_carry = Functions::valueKeyInArray($item, 'to_carry', 0);
                $orden_item->status_orden_id = 1;
                $orden_item->date = Carbon::today();
                $orden_item->time = date('H:i:s');
                $orden_item->area_id = $item['food']['area_id'];
                $orden_item->save();

                // Set area_id and multiply quantities like OrdenController
                $promotion_items = null;
                if (!empty($item['promotion_items'])) {
                    $promotion_items = $item['promotion_items'];
                } elseif (!empty($item['food']['promotion_items'])) {
                    $promotion_items = $item['food']['promotion_items'];
                } elseif (!empty($item['food']['item']['promotion_items'])) {
                    $promotion_items = $item['food']['item']['promotion_items'];
                }

                // Si el item trae promotion_items (es una promoción) — puede venir en distintas rutas/niveles — normalizamos y guardamos los detalles
                // Posibles ubicaciones: $item['promotion_items'], $item['food']['promotion_items'], $item['food']['item']['promotion_items']
                $promotion_items = null;
                if (!empty($item['promotion_items'])) {
                    $promotion_items = $item['promotion_items'];
                } elseif (!empty($item['food']['promotion_items'])) {
                    $promotion_items = $item['food']['promotion_items'];
                } elseif (!empty($item['food']['item']['promotion_items'])) {
                    $promotion_items = $item['food']['item']['promotion_items'];
                }

                if (!empty($promotion_items)) {
                    Log::info('Guardando promotion_items para orden_item_id: ' . $orden_item->id);
                    try {
                        // promotion_items puede venir como Collection o array
                        if ($promotion_items instanceof \Illuminate\Support\Collection) {
                            $promotion_items = $promotion_items->toArray();
                        }

                        foreach ($promotion_items as $p_item) {
                            // Diferentes formas posibles del detalle de promoción
                            $detail_item_id = null;
                            if (isset($p_item['item']['id'])) {
                                $detail_item_id = $p_item['item']['id'];
                            } elseif (isset($p_item['id'])) {
                                $detail_item_id = $p_item['id'];
                            } elseif (isset($p_item['item_id'])) {
                                $detail_item_id = $p_item['item_id'];
                            }

                            $detail_description = $p_item['description'] ?? ($p_item['item']['description'] ?? ($p_item['name'] ?? null));
                            $detail_quantity = $p_item['quantity'] ?? ($p_item['item_quantity'] ?? ($p_item['quantity_item'] ?? 1));

                            // Multiplicar la cantidad del detalle por la cantidad del item padre (comportamiento consistente con OrdenController)
                            $detail_quantity_final = $detail_quantity * (float) $orden_item->quantity;

                            // Determinar área del detalle: preferir la que venga en el input, luego la del item registrado, por último la del item padre
                            $area_id_from_input = data_get($p_item, 'item.area_id');
                            $area_id_for_detail = $area_id_from_input ?? null;
                            if (empty($area_id_for_detail) && $detail_item_id) {
                                try {
                                    $sub_item = Item::find($detail_item_id);
                                    if ($sub_item && isset($sub_item->area_id)) {
                                        $area_id_for_detail = $sub_item->area_id;
                                    }
                                } catch (\Exception $e) {
                                    $area_id_for_detail = null;
                                }
                            }
                            if (empty($area_id_for_detail)) {
                                $area_id_for_detail = $orden_item->area_id ?? null;
                            }

                            $user_id_for_detail = $user_id ?? null;

                            OrderItemDetail::create([
                                'orden_item_id' => $orden_item->id,
                                'item_id' => $detail_item_id,
                                'description' => $detail_description,
                                'quantity' => $detail_quantity_final,
                                'area_id' => $area_id_for_detail,
                                'user_id' => $user_id_for_detail,
                            ]);
                        }
                    } catch (\Exception $ex) {
                        // No queremos que falle todo el envío de crédito por un detalle de promoción
                        Log::error('Error guardando promotion_items en order_item_details: ' . $ex->getMessage());
                    }
                }
                $orden_items_ids[] = $orden_item->id;
                $orden_items_ids_for_kitchen[] = [
                    "orden_id" => $orden_item->id,
                    "area_id" => $orden_item->area_id
                ];


                event(new OrdenEvent($orden_item->id));
            } */
            foreach ($items as $item) {
                $orden_item = new OrdenItem;
                $orden_item->food_id = $item['food']['id'];
                $orden_item->observations = $item['observation'] ?? '-';
                $orden_item->quantity = $item['quantity'];
                $orden_item->unit_type_id = Functions::valueKeyInArray($item, 'type_id', null);
                $orden_item->price = $item['price'];
                $orden_item->user_id = $user_id;
                $orden_item->orden_id = $orden->id;
                $orden_item->to_carry = Functions::valueKeyInArray($item, 'to_carry', 0);
                $orden_item->status_orden_id = 1;
                $orden_item->date = Carbon::today();
                $orden_item->time = date('H:i:s');
                $orden_item->area_id = $item['food']['area_id'];
                $orden_item->save();

                // Agregamos la primera área (del item principal)
                $orden_items_ids_for_kitchen[] = [
                    "orden_id" => $orden_item->id,
                    "area_id" => $orden_item->area_id
                ];

                // Procesar promoción (si aplica)
                $promotion_items = $item['promotion_items']
                    ?? $item['food']['promotion_items']
                    ?? $item['food']['item']['promotion_items']
                    ?? null;

                if (!empty($promotion_items)) {
                    if ($promotion_items instanceof \Illuminate\Support\Collection) {
                        $promotion_items = $promotion_items->toArray();
                    }

                    foreach ($promotion_items as $p_item) {
                        $detail_item_id = $p_item['item']['id']
                            ?? $p_item['id']
                            ?? $p_item['item_id']
                            ?? null;

                        $detail_description = $p_item['description']
                            ?? ($p_item['item']['description'] ?? ($p_item['name'] ?? null));

                        $detail_quantity = $p_item['quantity']
                            ?? ($p_item['item_quantity'] ?? ($p_item['quantity_item'] ?? 1));

                        $detail_quantity_final = $detail_quantity * (float) $orden_item->quantity;

                        $area_id_for_detail = data_get($p_item, 'item.area_id')
                            ?? optional(Item::find($detail_item_id))->area_id
                            ?? $orden_item->area_id;

                        $user_id_for_detail = $user_id;

                        OrderItemDetail::create([
                            'orden_item_id' => $orden_item->id,
                            'item_id' => $detail_item_id,
                            'description' => $detail_description,
                            'quantity' => $detail_quantity_final,
                            'area_id' => $area_id_for_detail,
                            'user_id' => $user_id_for_detail,
                        ]);

                        // 🔹 También agregar detalle de promoción al array de impresión
                        $orden_items_ids_for_kitchen[] = [
                            "orden_id" => $orden_item->id,
                            "area_id" => $area_id_for_detail
                        ];
                    }
                }

                $orden_items_ids[] = $orden_item->id;

                // Disparar evento por item
                event(new OrdenEvent($orden_item->id));
            }

            $print_box = $configuration->print_commands;
            $print_kitchen = $configuration->print_kitchen;
            if ($print_kitchen) {
                $ids_areas = array_unique(array_column($orden_items_ids_for_kitchen, "area_id"));
                foreach ($ids_areas as $area_id) {
                    $filtered = array_column(array_filter($orden_items_ids_for_kitchen, function ($a) use ($area_id) {
                        return $area_id == $a['area_id'];
                    }), "orden_id");
                    event(new PrintEvent($orden->id, "0", true, $area_id, $filtered));
                }
            }

            Log::info('Áreas únicas para impresión en cocina:dadadadfsdqsfgsdgdf ');
            $credit_list =  CreditList::create([
                'cash_id' => $cash_id,
                'orden_id' => $orden->id,
                'customer_id' => $customer_id,
                'user_id' => $user_id,
                'establishment_id' => auth()->user()->establishment_id,
                'observation' => $request->ref,
                'paid' => false,
            ]);

            Log::info("CreditList creado con ID:4ertetertertertert");
            $this->update_stock($credit_list);

            Log::info("Intentando imprimir crédito para CreditList ID DAFSDFSDFSDFDF: {$credit_list->id}");

            event(new PrintEvent($credit_list->id, 'S', true, null, []));
            sleep(1);
            event(new PrintEvent($credit_list->id, 'S', true, null, []));

            DB::commit();

            return [
                'success' => true,
                'message' => 'Credito enviado correctamente'
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }


    public function send_credit_restobar(Request $request)
    {
        $configuration = Configuration::firstOrFail();
        $cash_id = $request->cash_id;
        try {
            DB::beginTransaction();
            $customer_id = $request->customer_id;
            $ref = $request->ref;
            $customer = Person::find($customer_id);
            $customer_name = $customer->name;
            $items = $request->items;
            $user_id = auth()->id();
            $table_caja_id = Table::get_caja();
            $table_caja = Table::find($table_caja_id);
            $table_caja->status_table_id = 2;
            $table_caja->save();
            $status_orden_id = 1;
            $orden = Orden::create([
                'table_id' => $table_caja_id,
                'status_orden_id' => $status_orden_id,
                'date' => date('Y-m-d'),
                'ref' => $customer_name . ' - ' . $ref,
            ]);
            $orden_items_ids = [];
            $orden_items_ids_for_kitchen = [];
            foreach ($items as $item) {
                $orden_item = new OrdenItem;
                $orden_item->food_id = $item['food']['id'];
                $orden_item->observations = $item['observation'] ?? '-';
                $orden_item->quantity = $item['quantity'];
                $orden_item->unit_type_id = Functions::valueKeyInArray($item, 'type_id', null);
                $orden_item->price = $item['price'];
                $orden_item->user_id = $user_id;
                $orden_item->orden_id = $orden->id;
                $orden_item->to_carry = Functions::valueKeyInArray($item, 'to_carry', 0);
                $orden_item->status_orden_id = 1;
                $orden_item->date = Carbon::today();
                $orden_item->time = date('H:i:s');
                $orden_item->area_id = $item['food']['area_id'];
                $orden_item->save();
                $orden_items_ids[] = $orden_item->id;
                $orden_items_ids_for_kitchen[] = [
                    "orden_id" => $orden_item->id,
                    "area_id" => $orden_item->area_id
                ];
                event(new OrdenEvent($orden_item->id));
            }
            $print_box = $configuration->print_commands;
            $print_kitchen = $configuration->print_kitchen;
            if ($print_kitchen) {
                $ids_areas = array_unique(array_column($orden_items_ids_for_kitchen, "area_id"));
                foreach ($ids_areas as $area_id) {
                    $filtered = array_column(array_filter($orden_items_ids_for_kitchen, function ($a) use ($area_id) {
                        return $area_id == $a['area_id'];
                    }), "orden_id");
                    event(new PrintEvent($orden->id, "0", true, $area_id, $filtered));
                }
            }
            // $isFromBox = $this->isArea("CAJ", $user->area_id);

            if ($print_box) {
                // event(new PrintEvent($orden->id, "0", true, $this->getBoxArea(), $orden_items_ids));
            }
            $credit_list =  CreditList::create([
                'cash_id' => $cash_id,
                'orden_id' => $orden->id,
                'customer_id' => $customer_id,
                'user_id' => $user_id,
                'establishment_id' => auth()->user()->establishment_id,
                'observation' => $request->ref,
                'paid' => false,
            ]);
            $this->update_stock($credit_list);

            event(new PrintEvent($credit_list->id, 'S', true, null, []));
            sleep(1);
            event(new PrintEvent($credit_list->id, 'S', true, null, []));

            DB::commit();

            return [
                'success' => true,
                'message' => 'Credito enviado correctamente'
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        // $orden_id = $request->orden_id;
    }
    function getBoxArea()
    {
        $establishment_id = auth()->user()->establishment_id;
        $user_box = User::whereHas('area', function ($query) {
            $query->where('description', 'like', '%CAJ%');
        })->where('establishment_id', $establishment_id)->first();
        if ($user_box) {
            $area_box = $user_box->area;
            return $area_box->id;
        }
        $area_box = Area::where('description', 'like', '%CAJ%')->first();

        if ($area_box != null) {
            return $area_box->id;
        }
        return null;
    }
    public function tables()
    {
        /* $printers = Area::whereNotNull('printer')->get()
            ->transform(function ($row, $key) {
                return [
                    'id' => $row->id,
                    'description' => $row->description,
                    'printer' => $row->printer,
                ];
            }); */
        $persons = Person::all();
        $establishments = Establishment::all();
        /* $series = Series::all(); */
        return [
            'success' => true,
            /* 'printers' => $printers, */
            'establishments' => $establishments,
            'persons' => $persons
            /* 'series' => $series, */
        ];
    }
    public function records(Request $request)
    {
        $value = $request->value;
        //saca los registros que tengan paid en false pero agrupados por customer_id
        $credit_lists = CreditList::select('customer_id', DB::raw('count(*) as count'));
        if ($value) {
            $credit_lists = $credit_lists->whereHas('customer', function ($query) use ($value) {
                $query->where('name', 'like', "%{$value}%")
                    ->orWhere('number', 'like', "%{$value}%");
            });
        }
        $credit_lists =            $credit_lists->where('paid', false)
            ->groupBy('customer_id');

        return new CreditListCollection($credit_lists->paginate(config('tenant.items_per_page')));
    }
    public function get_ordens($customer_id)
    {
        $credit_lists = CreditList::where('customer_id', $customer_id)
            ->where('paid', false)
            ->with(['orden.orden_items'])
            ->get()
            ->flatMap(function ($creditList) {
                return $creditList->orden->orden_items->map(function ($ordenItem) {
                    return [
                        'id' => $ordenItem->id,
                        'food' => $ordenItem->food,
                        'observations' => $ordenItem->observations,
                        'quantity' => $ordenItem->quantity,
                        'unit_type_id' => $ordenItem->unit_type_id,
                        'price' => $ordenItem->price,
                        'user_id' => $ordenItem->user_id,
                        'orden_id' => $ordenItem->orden_id,
                        'to_carry' => $ordenItem->to_carry,
                        'status_orden_id' => $ordenItem->status_orden_id,
                        'date' => $ordenItem->date,
                        'time' => $ordenItem->time,
                        'area_id' => $ordenItem->area_id,
                    ];
                });
            });

        return $credit_lists;
    }
    public function get_balance($customer_id)
    {
        $balance = CreditList::where('customer_id', $customer_id)
            ->where('paid', false)
            ->with(['orden.orden_items'])
            ->get()
            ->flatMap(function ($creditList) {
                return $creditList->orden->orden_items->map(function ($ordenItem) {
                    return $ordenItem->quantity * $ordenItem->price;
                });
            })
            ->sum();

        return $balance;
    }
}
