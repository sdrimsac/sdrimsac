<?php

namespace App\Http\Controllers\Tenant;

use App\CoreFacturalo\Requests\Inputs\Functions;
use App\Exports\CreditListExport;
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
use Modules\Restaurant\Events\OrdenEvent;
use Modules\Restaurant\Events\PrintEvent;
use Modules\Restaurant\Models\Area;
use Modules\Restaurant\Models\Food;
use Maatwebsite\Excel\Excel;

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
        // Puedes filtrar por mes si deseas
        $month = $request->input('month', now()->format('m'));
        $year = $request->input('year', now()->format('Y'));

        // Obtener todos los empleados (personas con is_staff)
        $empleados = Person::where('is_staff', true)->get();

        foreach ($empleados as $empleado) {

            $registros = PersonAttendance::where('person_id', $empleado->id)
                ->whereYear('date_attendance', $year)
                ->whereMonth('date_attendance', $month)
                ->orderBy('date_time_attendance')
                ->get()
                ->groupBy('date_attendance');

            foreach ($registros as $fecha => $marcas) {

                // Construir array de horas (HH:MM:SS) por cada marca del día.
                $times = $marcas->map(function ($r) {
                    if (!empty($r->time_attendance)) return $r->time_attendance;
                    if (!empty($r->date_time_attendance)) return Carbon::parse($r->date_time_attendance)->format('H:i:s');
                    return null;
                })->filter()->values();

                $horasTrabajadas = 0;
                $workedMinutes = 0;
                $hasUnpaired = false;
                $lastPairedEnd = null;

                // Emparejar marcas: 0-1, 2-3, ... sumar solo intervalos emparejados
                for ($i = 0; $i < $times->count(); $i += 2) {
                    $startStr = $times->get($i);
                    if ($startStr === null) continue;
                    if ($times->has($i + 1)) {
                        $endStr = $times->get($i + 1);
                        if ($endStr === null) {
                            $hasUnpaired = true;
                            continue;
                        }
                        $start = Carbon::parse($fecha . ' ' . $startStr);
                        $end = Carbon::parse($fecha . ' ' . $endStr);
                        if ($end->lt($start)) {
                            $end->addDay();
                        }
                        $workedMinutes += $start->diffInMinutes($end);
                        $lastPairedEnd = Carbon::parse($endStr)->format('H:i:s');
                    } else {
                        // marca sin pareja (entrada sin salida)
                        $hasUnpaired = true;
                    }
                }

                $horasTrabajadas = $workedMinutes / 60;

                // Entrada: primera marca del día (si existe). Salida: última salida pareada si existe,
                // si no existe usar la última marca (posiblemente una entrada sin salida) o 00:00:00
                $entrance_val = $times->count() ? $times->first() : '00:00:00';
                if ($lastPairedEnd) {
                    $exit_val = $lastPairedEnd;
                } else {
                    $exit_val = $times->count() ? $times->last() : '00:00:00';
                }

                $horasExtras = max(0, $horasTrabajadas - 8);

                $horaBase = ($empleado->base_salary ?? 0) / 30 / 8;
                $montoExtra = 0;
                if ($horasExtras > 0) {
                    if ($horasExtras <= 2) {
                        $montoExtra = $horasExtras * $horaBase * 1.25;
                    } else {
                        $montoExtra = (2 * $horaBase * 1.25) + (($horasExtras - 2) * $horaBase * 1.35);
                    }
                }

                // Marcar falta si no hay marcas o existe alguna marca sin pareja (entrada sin salida)
                $falta = ($times->count() == 0) || $hasUnpaired;

                WorkerDailySummari::updateOrCreate(
                    [
                        'person_id' => $empleado->id,
                        'date_daily' => $fecha
                    ],
                    [
                        'entrance' => $entrance_val,
                        'exit' => $exit_val,
                        'horas_trabajadas' => round($horasTrabajadas, 2),
                        'overtime' => round($horasExtras, 2),
                        'amount_extra' => round($montoExtra, 2),
                        'lack' => $falta,
                    ]
                );
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Resumen diario generado correctamente'
        ]);
    }

    /* public function getRecords(Request $request)
    {
        // obtener los persons  donde is_staff = true y tambien obtner la realcionn de dias de la tabla worker_daily_summaries
        $query = Person::query()->where('is_staff', true);
        $query->with('worker_daily_summaries');
        $query->orderBy('name')->paginate(20);
        return $query;
    } */
    /* public function recordsWorker(Request $request)
    {
        $records = $this->getRecords($request);

        return StaffPersonWorkerCollection::collection($records)->paginate(20);
    } */

    /* public function recordsWorker(Request $request)
    {
        $records = $this->getRecords($request)->paginate(20);

        return StaffPersonWorkerCollection::collection($records);
    } */

    public function recordsWorker(Request $request)
    {
        $query = WorkerDailySummari::with('person')
            ->whereHas('person', function ($q) {
                $q->where('is_staff', true);
            });

        if ($request->filled('date')) {
            $query->where('date_daily', $request->date);
        }

        if ($request->filled('person_id')) {
            $query->where('person_id', $request->person_id);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('date_daily', [$request->from_date, $request->to_date]);
        }

        $records = $query->orderBy('date_daily', 'desc')->paginate(20);

        //return StaffPersonWorkerCollection::collection($records);
        return new StaffPersonWorkerCollection($records);
    }


    /* public function getRecords(Request $request)
    {
        $records = Person::where('is_staff', true)
            ->with('worker_daily_summaries')
            ->orderBy('name');

        // Filtro por nombre
        if ($request->has('name') && $request->name != '') {
            $records->where('name', 'like', "%{$request->name}%");
        }

        // Filtro por fecha en la relación worker_daily_summaries
        if ($request->has('date') && $request->date != '') {
            $records->whereHas('worker_daily_summaries', function ($q) use ($request) {
                $q->where('date_daily', $request->date);
            });
        }

        // Filtro por cliente u otra cosa
        if ($request->has('client_id') && $request->client_id != '') {
            $records->where('client_id', $request->client_id);
        }

        return $records;
    } */

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
                if (!$item->is_set) {

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
        $printers = Area::whereNotNull('printer')->get()
            ->transform(function ($row, $key) {
                return [
                    'id' => $row->id,
                    'description' => $row->description,
                    'printer' => $row->printer,
                ];
            });
        $establishments = Establishment::all();
        $series = Series::all();
        return [
            'success' => true,
            'printers' => $printers,
            'establishments' => $establishments,
            'series' => $series,
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
