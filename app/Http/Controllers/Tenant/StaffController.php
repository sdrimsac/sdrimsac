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
use App\Models\Tenant\ItemPromotion;
use App\Models\Tenant\ItemSet;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\JobPosition;
use App\Models\Tenant\Payment;
use App\Models\Tenant\Person;
use App\Models\Tenant\PersonAttendance;
use App\Models\Tenant\Series;
use App\Models\Tenant\User;
use App\Models\Tenant\Warehouse;
use App\Models\Tenant\WorkerAdvance;
use App\Models\Tenant\WorkerConsumption;
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

    /**
     * Update only the job position for a person (partial update).
     * Expects: person_id, job_position_id (nullable)
     */
    public function updateJobPosition(Request $request)
    {
        try {
            $record = WorkerDailySummari::find($request->input('worker_daily_summary_id'));
            if (!$record) {
                return response()->json(['success' => false, 'message' => 'Registro diario no encontrado'], 404);
            }

            $record->job_position_id = $request->input('job_position_id') ?? null;
            $record->save();

            return response()->json(['success' => true, 'data' => $record]);
        } catch (\Exception $e) {
            Log::error('updateJobPosition error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al actualizar el cargo diario'], 500);
        }
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

        $empleados = Person::where('is_staff', true)->whereNotNull('job_position_id')->get();
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

            $filtered = [];
            foreach ($marks as $m) {
                if (empty($filtered)) {
                    $filtered[] = $m;
                    continue;
                }
                $last = end($filtered);
                $diffSeconds = $last['dt']->diffInSeconds($m['dt']);
                if ($diffSeconds <= 5 && $last['type'] === $m['type']) {
                    continue;
                }
                $filtered[] = $m;
            }

            $pairsByDate = [];
            $unpairedByDate = [];
            $i = 0;
            $count = count($filtered);
            while ($i < $count) {
                $start = $filtered[$i];
                $end = null;
                for ($j = $i + 1; $j < $count; $j++) {
                    if ($start['type'] && strpos($start['type'], 'ing') !== false) {
                        if (isset($filtered[$j]['type']) && strpos($filtered[$j]['type'], 'sal') !== false) {
                            $end = $filtered[$j];
                            $i = $j + 1;
                            break;
                        }
                    } else {
                        $end = $filtered[$j];
                        $i = $j + 1;
                        break;
                    }
                }

                if ($end === null) {
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
                    $i++;
                    continue;
                }

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

            foreach ($pairsByDate as $fecha => $data) {
                $workedMinutes = $data['minutes'];
                $horasTrabajadas = $workedMinutes / 60;

                $pairs_array = $data['pairs'] ?? [];

                $fecha_salida = $fecha;
                if (!empty($pairs_array)) {
                    $lastPair = end($pairs_array);
                    if (!empty($lastPair['exit_date'])) {
                        $fecha_salida = $lastPair['exit_date'];
                    }
                }

                $horasExtras = max(0, $horasTrabajadas - 8);

                $monthlySalary = 0.0;
                if (isset($empleado->base_salary)) {
                    $monthlySalary = (float) $empleado->base_salary;
                } elseif (isset($empleado->{'base-salary'})) {
                    $monthlySalary = (float) $empleado->{'base-salary'};
                } elseif (isset($empleado->salary)) {
                    $monthlySalary = (float) $empleado->salary;
                }
                $horaBase = $monthlySalary / 30 / 8;

                $montoExtra = 0;
                if ($horasExtras > 0 && $horaBase > 0) {
                    if ($horasExtras <= 2) {
                        $montoExtra = $horasExtras * $horaBase * 1.25;
                    } else {
                        $montoExtra = (2 * $horaBase * 1.25) + (($horasExtras - 2) * $horaBase * 1.35);
                    }
                }
                $falta = ($horasTrabajadas < 8);
                $minutesMissing = 0;
                if ($falta) {
                    $minutesMissing = max(0, 480 - $workedMinutes);
                }

                WorkerDailySummari::updateOrCreate(
                    [
                        'person_id' => $empleado->id,
                        'date_daily' => $fecha
                    ],
                    [
                        'pairs' => $pairs_array,
                        'entrance' => null,
                        'exit' => null,
                        'job_position_id' => $empleado->job_position_id,
                        'horas_trabajadas' => gmdate('H:i:s', $workedMinutes * 60),
                        'overtime' => round($horasExtras, 2),
                        'amount_extra' => round($montoExtra, 2),
                        'lack' => $falta,
                        'date_end_daily' => $fecha_salida,
                        'extra_time_two' => gmdate('H:i:s', ($horasExtras > 2 ? 2 : $horasExtras) * 3600),
                        'extra_time_three' => gmdate('H:i:s', ($horasExtras > 2 ? $horasExtras - 2 : 0) * 3600),
                        'lack_time' => $falta ? gmdate('H:i:s', $minutesMissing * 60) : null,
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

        Log::info('getRecords called with request: ' . json_encode($request->all()));
        $waTable = (new WorkerAdvance)->getTable();
        $wdTable = (new WorkerDailySummari)->getTable();
        $advancesSub = DB::connection('tenant')->table($waTable)
            ->select(
                "{$waTable}.person_id",
                DB::raw("DATE({$waTable}.date_time_advance) as adv_date"),
                DB::raw("SUM({$waTable}.amount) as advances_sum")
            )
            ->groupBy("{$waTable}.person_id", DB::raw("DATE({$waTable}.date_time_advance)"));

        $query = WorkerDailySummari::with('person')
            ->leftJoinSub($advancesSub, 'wa', function ($join) use ($wdTable) {
                $join->on("{$wdTable}.person_id", '=', 'wa.person_id')
                    ->on("{$wdTable}.date_daily", '=', 'wa.adv_date');
            })
            ->select("{$wdTable}.*", DB::raw("COALESCE(wa.advances_sum, 0) as advances"))
            ->whereHas('person', function ($q) {
                $q->where('is_staff', true);
            });
        if ($request->filled('person_id')) {
            $query->where("{$wdTable}.person_id", $request->person_id);
        }
        if ($request->filled('date_day')) {
            $query->whereDate("{$wdTable}.date_daily", $request->date_day);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $from = Carbon::parse($request->from_date)->format('Y-m-d');
            $to = Carbon::parse($request->to_date)->format('Y-m-d');
            $query->whereBetween("{$wdTable}.date_daily", [$from, $to]);
        }

        if ($request->filled('month')) {
            [$year, $month] = explode('-', $request->month);
            $query->whereYear("{$wdTable}.date_daily", $year)
                ->whereMonth("{$wdTable}.date_daily", $month);
        }

        if ($request->filled('date')) {
            $dateVal = $request->date;
            if (preg_match('/^\d{4}-\d{2}-00$/', $dateVal)) {
                $dateVal = substr($dateVal, 0, 7);
            }
            if (preg_match('/^\d{4}-\d{2}$/', $dateVal)) {
                [$y, $m] = explode('-', $dateVal);
                $query->whereYear("{$wdTable}.date_daily", $y)
                    ->whereMonth("{$wdTable}.date_daily", $m);
            } else {
                $query->whereDate("{$wdTable}.date_daily", $dateVal);
            }
        }
        $records = $query->orderBy("{$wdTable}.date_daily", 'desc');

        return $records;
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
        return (new StaffWorkerExport)
            ->records($records)
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
        Log::info('update_stock called for CreditList ID: ' . $credit_list->id);
        $orden = Orden::find($credit_list->orden_id);
        $items = $orden->orden_items;
        $warehouse = $this->findWarehouse();

        foreach ($items as $orden_item) {
            $food_id = $orden_item->food_id;
            Log::info('Processing orden_item with food_id: ' . $food_id);
            $quantity = $orden_item->quantity * -1;
            $food = Food::find($food_id);
            $item_id = $food->item_id;
            $item = Item::find($item_id);
            Log::info('Processing item with item_id: ' . $item_id);

            if ($item->unit_type_id !== 'ZZ') {

                Log::info('Updating stock for item_id: ' . $item_id . ' with quantity: ' . $quantity);
                if (!$item->is_set && !$item->promotion_items) {
                    $this->createInventoryKardex($item_id, $quantity, $warehouse->id, $credit_list);
                    Log::info('Creating inventory kardex for item_id: ' . $item_id . ' with quantity: ' . $quantity);
                    $this->updateStock($item_id, $quantity, $warehouse->id);
                    Log::info('Stock updated for item_id: ' . $item_id);

                    // 2️⃣ Item tipo set
                } elseif ($item->is_set) {
                    $item_sets = ItemSet::where('set_id', $item_id)->get();
                    foreach ($item_sets as $set_item) {
                        // Multiplicar por -1 para descontar stock (salida)
                        $total_quantity = $set_item->quantity * $orden_item->quantity * -1;
                        Log::info("update_stock: set item_component={$set_item->individual_item_id} qty={$total_quantity}");
                        $this->createInventoryKardex($set_item->individual_item_id, $total_quantity, $warehouse->id, $credit_list);
                        try {
                            $this->updateStock($set_item->individual_item_id, $total_quantity, $warehouse->id);
                        } catch (Exception $e) {
                            Log::error('updateStock error for set component: ' . $e->getMessage());
                            throw $e;
                        }
                    }

                    // 3️⃣ Item de promoción
                } elseif ($item->promotion_items) {
                    $promotion_items = ItemPromotion::where('item_id', $item_id)->get();
                    foreach ($promotion_items as $promo_item) {
                        // Cada registro en items_promotions tiene 'promotion_item_id' y 'quantity' (cantidad por promoción)
                        $promo_item_obj = Item::find($promo_item->promotion_item_id);
                        $promo_quantity = isset($promo_item->quantity) ? floatval($promo_item->quantity) : 1;

                        if ($promo_item_obj && $promo_item_obj->is_set) {
                            // Si el item de la promoción es un set, descontar los insumos del set
                            $set_items = ItemSet::where('set_id', $promo_item_obj->id)->get();
                            foreach ($set_items as $set_item) {
                                // multiplicar por la cantidad dentro del set, por la cantidad de promo y por la cantidad ordenada
                                $total_quantity = $set_item->quantity * $promo_quantity * $orden_item->quantity * -1;
                                Log::info("update_stock: promo(set) component={$set_item->individual_item_id} qty={$total_quantity}");
                                $this->createInventoryKardex($set_item->individual_item_id, $total_quantity, $warehouse->id, $credit_list);
                                try {
                                    $this->updateStock($set_item->individual_item_id, $total_quantity, $warehouse->id);
                                } catch (Exception $e) {
                                    Log::error('updateStock error for promo set component: ' . $e->getMessage());
                                    throw $e;
                                }
                            }
                        } else {
                            // Item normal dentro de la promoción: descontar promo_quantity * orden quantity
                            $total_quantity = $promo_quantity * $orden_item->quantity * -1;
                            Log::info("update_stock: promo item={$promo_item->promotion_item_id} qty={$total_quantity}");
                            $this->createInventoryKardex($promo_item_obj->id, $total_quantity, $warehouse->id, $credit_list);
                            try {
                                $this->updateStock($promo_item_obj->id, $total_quantity, $warehouse->id);
                            } catch (Exception $e) {
                                Log::error('updateStock error for promo item: ' . $e->getMessage());
                                throw $e;
                            }
                        }
                    }
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

            $credit_list =  CreditList::create([
                'cash_id' => $cash_id,
                'orden_id' => $orden->id,
                'customer_id' => $customer_id,
                'user_id' => $user_id,
                'establishment_id' => auth()->user()->establishment_id,
                'observation' => $request->ref,
                'paid' => false,
            ]);
            $worker_consumptions =  WorkerConsumption::create([
                'person_id' => $customer_id,
                'amount' => $orden->getTotal(),
                'date_time_consumption' => now(),
                'obervation' => $request->ref,
            ]);

            Log::info("CreditList creado con ID:4ertetertertertert", $credit_list->toArray());
            $this->update_stock($credit_list);

            //Log::info("Intentando imprimir crédito para CreditList ID DAFSDFSDFSDFDF: {$credit_list->id}");

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
        $persons = Person::where('is_staff', 1)->select('id', 'name')->get();
        $establishments = Establishment::all();
        $job_positions = JobPosition::all();
        /* $series = Series::all(); */
        return [
            'success' => true,
            /* 'printers' => $printers, */
            'establishments' => $establishments,
            'persons' => $persons,
            'job_positions' => $job_positions,
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
