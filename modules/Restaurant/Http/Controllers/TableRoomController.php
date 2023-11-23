<?php

namespace Modules\Restaurant\Http\Controllers;

use App\CoreFacturalo\Requests\Inputs\Common\PersonInput;
use App\CoreFacturalo\Services\Models\Person;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\HotelRent;
use App\Models\Tenant\HotelRentItem;
use App\Models\Tenant\HotelRentItemPerson;
use App\Models\Tenant\Item;
use App\Models\Tenant\Person as TenantPerson;
use App\Models\Tenant\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Item\Models\CategoryItem;
use Modules\Restaurant\Models\Table;
use Modules\Restaurant\Http\Requests\TableRequest;
use Modules\Restaurant\Http\Resources\HotelRentItemResource;
use Modules\Restaurant\Http\Resources\TableCollection;
use Modules\Restaurant\Models\DetailTable;
use Modules\Restaurant\Models\Floor;
use Modules\Restaurant\Models\Food;
use Modules\Restaurant\Models\HotelRentItemServices;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\OrdenItem;
use Modules\Restaurant\Models\RoomService;
use Modules\Restaurant\Models\StatusTable;
use Modules\Restaurant\Models\TableMaintenance;
use Modules\Restaurant\Models\TableRoomService;
use Modules\Restaurant\Models\TableType;
use Modules\Restaurant\Models\Tower;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Modules\Restaurant\Events\PrintEvent;

class TableRoomController extends Controller
{
    public function desactive_promotion($id)
    {
        $promotion = HotelRentItemServices::findOrFail($id);
        $promotion->active = false;
        $promotion->save();
        return [
            'success' => true,
            'message' => 'Promoción entregada'
        ];
    }

    public function get_promotion($code)
    {

        // 'id' => 0,
        // 'observation' => '',
        // 'food' => $service,
        // 'quantity' => 1,
        // 'price' => $service->price,
        $promotion = HotelRentItemServices::whereRaw('BINARY code=?', $code)->first();

        if ($promotion) {
            $room_service = $promotion->room_service;
            $promotion->has_items = (bool) $room_service->has_items;
            if ($promotion->has_items) {
                $formated = $this->formatedItems($room_service->items);
                $error = $formated['error'];
                if ($error) {
                    return [
                        'success' => false,
                        'message' => 'Producto no encontrado'
                    ];
                } else {
                    $promotion->items = $formated['items'];
                }
            }
            $promotion->name = $room_service->name;
            return [
                'success' => true,
                'data' => $promotion
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Código no encontrado'
            ];
        }
    }

    function formatedItems($items)
    {
        $formated_items = [];
        $error = false;
        $establishment_id = auth()->user()->establishment_id;
        $warehouse_id = Warehouse::where('establishment_id', $establishment_id)->first()->id;
        foreach ($items as $item) {
            $food_id = $item['food_id'];

            $food = Food::whereHas(
                'item',
                function ($query)
                use ($warehouse_id) {
                    $query->whereHas('warehouses', function ($query) use ($warehouse_id) {
                        $query->where('warehouse_id', $warehouse_id);
                    });
                }
            )->where('id', $food_id)->first();

            if ($food) {
                $quantity = $item['quantity'];
                $formated_items[] = [
                    'id' => 0,
                    'observation' => '',
                    'food' => $food,
                    'quantity' => $quantity,
                    'price' => $food->price,
                ];
            } else {
                $error = true;
                break;
            }
        }
        if ($error) {
            $formated_items = [];
        }

        return [
            'error' => $error,
            'items' => $formated_items
        ];
    }
    public function print_service($id)
    {
        $record = HotelRentItemServices::findOrFail($id);
        $room = null;
        $hotel_rent_item = $record->hotel_rent_item;
        $hotel_rent = $hotel_rent_item->hotel_rent;
        $customer_name = $hotel_rent->customer->name;
        $customer_number = $hotel_rent->customer->number;
        $table = $hotel_rent_item->table;
        $floor = $table->floor;
        $tower = $floor->tower;
        $table_number = $table->number;
        $user_name = $hotel_rent->user->name;
        $room = $table_number . ' - ' . $tower->name;
        $record->room = $room;
        $record->customer_name = $customer_name;
        $record->customer_number = $customer_number;
        $record->user_name = $user_name;
        $company = Company::active();
        $height = 230;
        try {
            $pdf = PDF::loadView('restaurant::table_room.services', compact(
                'record',
                'company'
            ))
                ->setPaper(array(0, 0, 249.45, $height));
        } catch (Exception $e) {
            return ['m' => $e->getMessage()];
        }

        return $pdf->stream('pdf_transfers.pdf');
    }
    public function delete($id)
    {
        $table = Table::find($id);
        $table->delete();
        return [
            'success' => true,
            'message' => 'Registro eliminado con éxito'
        ];
    }
    public function get_detail_table()
    {
        $detail_table = DetailTable::where('active', true)->get();
        return [
            'success' => true,
            'data' => $detail_table
        ];
    }
    public function detail_table(Request $request)
    {
        $id = $request->input('id');
        $detail_table = DetailTable::firstOrNew(['id' => $id]);

        $detail_table->fill($request->all());
        $detail_table->description = mb_strtoupper($detail_table->description);
        $detail_table->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Detalle actualizado con éxito' : 'Detalle creado con éxito'
        ];
    }
    public function deleteItem($type, $id)
    {
        $model = null;
        switch ($type) {
            case 'floors':
                $model = Floor::find($id);
                break;
            case 'towers':
                $model = Tower::find($id);
                break;
            default:
                $model = TableType::find($id);
                break;
        }
        $model->delete();
        return [
            'success' => true,
            'message' => 'Registro eliminado con éxito'
        ];
    }
    public function addDays($id, $days)
    {
        $hotel_rent_item = HotelRentItem::find($id);
        $hotel_rent =  $hotel_rent_item->hotel_rent;
        $old_total = $hotel_rent->total;
        $hotel_rent_item->duration = $days;
        $table = $hotel_rent_item->table;
        $price = $hotel_rent_item->is_month_rent ? $table->month_price : $table->price;
        $total = $price * $days;
        $hotel_rent_item->total = $total;
        $hotel_rent->total -= $old_total;
        $hotel_rent->total += $total;
        $hotel_rent->save();
        $estimated = $this->getDateAndTimeToLeave($hotel_rent_item->checkin_date, $hotel_rent_item->checkin_time, $days, $hotel_rent_item->is_month_rent);
        $hotel_rent_item->checkout_date_estimated = $estimated['checkout_date_estimated'];
        $hotel_rent_item->checkout_time_estimated = $estimated['checkout_time_estimated'];
        $hotel_rent_item->save();
        return [
            'success' => true,
            'message' => $hotel_rent_item->is_month_rent ? 'Meses agregados' : 'Días agregados'
        ];
    }
    public function cleaned($id)
    {
        $table = Table::find($id);
        $table->is_cleaning = false;
        $table->cleaning_start_date = null;
        if ($table->status_table_id == 5) {
            $table->status_table_id = 1;
        }
        $table->save();
        return [
            'success' => true,
            'message' => 'Habitación limpia'
        ];
    }
    public function sendToAvaible($id)
    {
        $table = Table::find($id);
        //busca el último registro de mantenimiento que este activo
        $table_maintenance = TableMaintenance::where('table_id', $id)
            ->where('active', true)
            ->orderBy('start_time', 'desc')
            ->first();
        if ($table_maintenance) {
            $table->status_table_id = $table_maintenance->table_status_id;
            $table_maintenance->end_time = Carbon::now()->format('Y-m-d H:i:s');
            $table_maintenance->active = false;
            $table_maintenance->save();
        } else {
            $table->status_table_id = 1;
        }
        $table->save();
        return [
            'success' => true,
            'message' => 'Habitación disponible'
        ];
    }

    public function sendToMaintenance($id)
    {
        $table = Table::find($id);
        TableMaintenance::create([
            'table_id' => $id,
            'table_status_id' => $table->status_table_id,
            'start_time' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        $table->status_table_id = 3;
        $table->save();
        return [
            'success' => true,
            'message' => 'Habitación enviada a mantenimiento'
        ];
    }
    public function sendToclean($id)
    {
        $configuration = Configuration::first();
        $minutes = $configuration->time_to_clean;
        $minutes = $minutes ?? 45;
        $table = Table::find($id);
        $table->is_cleaning = true;
        $table->cleaning_start_date = Carbon::now()->addMinutes($minutes);
        $table->save();
        return [
            'success' => true,
            'message' => 'Habitación siendo limpiada'
        ];
    }
    public function getRoom($id)
    {
        $room = HotelRentItem::where('table_id', $id)->orderBy('checkin_date', 'desc')
            ->orderBy('checkin_time', 'desc')

            ->first();


        return new HotelRentItemResource($room);
    }
    function get_item_service()
    {
        $item = Item::where('unit_type_id', 'ZZ')
            ->where('description', 'Servicio')
            ->first();
        if ($item) {
            $food = Food::where('item_id', $item->id)->first();
            return $food;
        } else {
            $configuration = Configuration::first();
            $affectation_igv_type_id = $configuration->affectation_igv_type_id;
            $item = Item::create(
                [
                    'stock' => 0,
                    'attributes' => [],
                    'item_type_id' => '01',
                    'unit_type_id' => 'ZZ',
                    'internal_id' => '000ZZ',
                    'description' => 'Servicio',
                    'currency_type_id' => 'PEN',
                    'sale_unit_price' => '1.00',
                    'sale_affectation_igv_type_id'  => $affectation_igv_type_id,
                    'purchase_affectation_igv_type_id' => $affectation_igv_type_id,
                ]
            );
            $category_food_id = CategoryItem::first()->id;
            $food = Food::create([
                'item_id' => $item->id,
                'description' => 'Servicio',
                'price' => '1.00',
                'category_food_id' => $category_food_id,
                'active' => true,
            ]);

            return $food;
        }
    }
    function create_description($hotel_rent_item)
    {
        $duration = $hotel_rent_item->duration;
        $table = $hotel_rent_item->table;
        $number = $table->number;

        return "Habitación n° $number por $duration días ";
    }
    function recalculate(HotelRentItem $hote_rent_item)
    {
        $table = $hote_rent_item->table;
        $price = $table->price;
        $total = $price * $hote_rent_item->duration;
        $hote_rent_item->total = $total;
        $hote_rent_item->save();
        $hotel_rent = $hote_rent_item->hotel_rent;
        $hotel_rent->total = $hotel_rent->items->sum('total');
        $hotel_rent->save();
    }
    public function changeRoom($to, $from)
    {
        $table_to = Table::find($to);
        $hotel_rent_item = HotelRentItem::where('table_id', $to)->orderBy('checkin_date', 'desc')
            ->orderBy('checkin_time', 'desc')
            ->first();
        $table_from = Table::find($from);
        $hotel_rent_item->table_id = $from;
        $hotel_rent_item->save();
        $table_to->status_table_id = 1;
        $table_to->save();
        $table_from->status_table_id = 2;
        $table_from->save();
        $this->recalculate($hotel_rent_item);
        return [
            'success' => true,
            'message' => 'Habitación cambiada'
        ];
    }

    public  function desocupied($id)
    {
        $hotel_rent_item = HotelRentItem::find($id);
        $table = $hotel_rent_item->table;
        $table->status_table_id = 5;
        $table->sendMessageDesocupied();
        $table->save();
        if ($hotel_rent_item && $hotel_rent_item->is_month_rent) {
            $hotel_rent_item->checkout_date = Carbon::now()->format('Y-m-d');
            $hotel_rent_item->checkout_time = Carbon::now()->format('H:i:s');
            $hotel_rent_item->payment_status = "Pagado";
            $hotel_rent_item->save();
        }
        $table->save();
        return [
            'success' => true,
            'message' => 'Habitación desocupada'
        ];
    }
    public  function advanceDocument($id)
    {
        $hotel_rent = HotelRent::find($id);
        $hotel_rent_items = $hotel_rent->items->where('advances', '>', 0);
        $customer_number  = $hotel_rent->customer->number;
        $hotel_rent_id = $id;
        $items = collect();
        foreach ($hotel_rent_items as $hotel_rent_item) {
            $service = $this->get_item_service();
            $service->price = $hotel_rent_item->advances;
            $concept =  "Adelanto de habitación n° " . $hotel_rent_item->table->number;
            if ($hotel_rent_item->is_month_rent) {
                $checkin_date = Carbon::parse($hotel_rent_item->checkin_date);
                //$day

                $checkin_date_more_one_month = $checkin_date->copy()->addMonth()->format('Y-m-d');
                //obtener el día y el mes de la fecha de checkin, el mes en letras
                $day = Carbon::parse($checkin_date)->format('d');
                $month = Carbon::parse($checkin_date)->format('m');
                $month = $this->getMonth($month);

                $day_one_more_month = Carbon::parse($checkin_date_more_one_month)->format('d');
                $month_one_more_month = Carbon::parse($checkin_date_more_one_month)->format('m');
                $month_one_more_month = $this->getMonth($month_one_more_month);
                $concept = "Alquiler de habitación n° " . $hotel_rent_item->table->number . " del $day de $month al $day_one_more_month de $month_one_more_month";
            }
            $service->description = $concept;
            $service->item->description = $concept;

            $items->push([
                'id' => 0,
                'observation' => '',
                'food' => $service,
                'quantity' => 1,
                'price' => $service->price,
            ]);
        }
        return compact(
            'items',
            'hotel_rent_id',
            'customer_number'
        );
    }
    function getMonth($m)
    {
        $months = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Setiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        ];
        return $months[$m];
    }
    public  function allOrdens(Request $request, $id)
    {
        $extra_time = $request->input('extra_time') ?? 0;
        $hotel_rent_item = HotelRentItem::find($id);
        $hotel_rent_item->extra_time = $extra_time;
        $hotel_rent_item->save();
        $customer_number  = $hotel_rent_item->hotel_rent->customer->number;
        $hotel_rent = $hotel_rent_item->hotel_rent;
        $hotel_rent_id = $hotel_rent->id;
        $advance = $hotel_rent->advance;
        $single_room = $hotel_rent->items->count() == 1;
        $hotel_rent_item_id = $id;
        $total =  $hotel_rent_item->total;
        $description = $this->create_description($hotel_rent_item);
        $extra_service = null;
        $service = $this->get_item_service();
        if ($extra_time > 0) {
            $extra_service = $this->get_item_service();
            $extra_service->price = $extra_time;
            $extra_service->description = "Media tarifa";
            $extra_service->item->description = "Media tarifa";
        }
        $service->price = $total - $advance;
        $service->description = $description;
        $service->item->description = $description;
        $orden_ids  = Orden::where('hotel_rent_item_id', $id)
            ->whereNull('document_id')
            ->whereNull('sale_note_id')
            ->get()->pluck('id');
        $hotel_rent_item_ids = [$id];
        $ordens_items = OrdenItem::whereHas('orden', function ($query) use ($hotel_rent_item_id) {
            $query->where('hotel_rent_item_id', $hotel_rent_item_id)
                ->whereNull('document_id')
                ->whereNull('sale_note_id');
        })->get()
            ->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'observation' => $row->observation,
                    'food' => $row->food,
                    'quantity' => $row->quantity,
                    'price' => number_format($row->price, 2),
                ];
            });

        //inserta en ordenes_items el servicio
        $ordens_items->push([
            'id' => 0,
            'observation' => '',
            'food' => $service,
            'quantity' => 1,
            'price' => $service->price,
        ]);
        if ($extra_service) {
            $ordens_items->push([
                'id' => 0,
                'observation' => '',
                'food' => $extra_service,
                'quantity' => 1,
                'price' => $extra_service->price,
            ]);
        }
        if ($single_room) {

            return compact('orden_ids', 'ordens_items', 'hotel_rent_id', 'customer_number');
        } else {
            return compact('orden_ids', 'ordens_items', 'hotel_rent_item_ids', 'customer_number');
        }
    }
    public function check()
    {
        $total = 0;
        $user = auth()->user();
        $establishment_id = $user->establishment_id;
        $tables = Table::where('status_table_id', 2)
            ->where('is_room', true)
            ->where(function ($q) use ($establishment_id) {
                $q->where('establishment_id', $establishment_id)->orWhereNull('establishment_id');
            })
            ->get();
        $number_tables = count($tables);

        if ($number_tables == 0) {
            return [
                'success' => false,
            ];
        }
        $ordens_desc = [];
        $number_ordens = 0;
        $orden_items = [];
        foreach ($tables as $table) {
            $ordens = Orden::where('table_id', $table->id)->whereIn('status_orden_id', [1, 2, 3])->get();
            $number_ordens += count($ordens);
            foreach ($ordens as $orden) {
                $ordens_desc[] = $orden->id;
                $items = OrdenItem::where('orden_id', $orden->id)->get()->toArray();
                $orden_items = array_merge($orden_items, $items);

                $total += OrdenItem::where('orden_id', $orden->id)->selectRaw('SUM(price * quantity) as total')->value('total');
            }
        }

        return [
            'items' => $orden_items,
            'ordenes' => $number_ordens,
            'success' => true,
            'total' => $total
        ];
    }
    public function index()
    {
        $configurations = Configuration::first();
        return view('restaurant::configuration.rooms', compact('configurations'));
    }
    public function columns()
    {
        return [
            'number' => 'Nº de habitación',
            'floor_id' => 'N° Piso',
            'description' => 'Incluye',
        ];
    }
    public function recordsByArea($id)
    {
        $establishment_id = auth()->user()->establishment_id;
        $tables = new TableCollection(Table::where('area_id', $id)
            ->where('is_room', true)
            ->where(function ($q) use ($establishment_id) {
                $q->where('establishment_id', $establishment_id)
                    ->orWhereNull('establishment_id');
            })
            ->get());

        return [
            'success' => true,
            'data' => $tables
        ];
    }
    public function tablesToLeave()
    {
        $configuration = Configuration::first();
        $time_to_leave = $configuration->alarm_to_end;
        $date = Carbon::now()->addMinutes($time_to_leave)->format('Y-m-d');
        $time = Carbon::now()->addMinutes($time_to_leave)->format('H:i:s');
        $tablesLeave = Table::with(['hotel_rent_items' => function ($query) use ($date, $time) {
            $query->where(function ($query) use ($date, $time) {
                $query->where('checkout_date_estimated', '<', $date)
                    ->orWhere(function ($query) use ($date, $time) {
                        $query->where('checkout_date_estimated', '=', $date)
                            ->where('checkout_time_estimated', '<', $time);
                    });
            })
                ->where('payment_status', 'Pendiente')
                ->where('was_cancel', 0);
        }])
            ->whereHas('hotel_rent_items', function ($query) use ($date, $time) {
                $query->where(function ($query) use ($date, $time) {
                    $query->where('checkout_date_estimated', '<', $date)
                        ->orWhere(function ($query) use ($date, $time) {
                            $query->where('checkout_date_estimated', '=', $date)
                                ->where('checkout_time_estimated', '<', $time);
                        });
                })
                    ->where('payment_status', 'Pendiente')
                    ->where('was_cancel', 0);
            })
            ->get();

        return [
            'success' => true,
            'data' => $tablesLeave
        ];
    }
    public function tablesToClean()
    {
        $tablesClean = DB::connection('tenant')->table('tables')->where('is_cleaning', true)->get();

        return [
            'success' => true,
            'data' => $tablesClean
        ];
    }

    public function tables(Request $request)
    {
        $is_reserve = $request->input('is_reserve');
        $is_reserve = $is_reserve == 'true' ? true : false;
        $table_types = TableType::where('active', true)->get();
        $towers = Tower::where('active', true)->get();
        $floors = Floor::where('active', true)->get();
        $tables = Table::where('is_room', true);
        $services = RoomService::where('active', true)->get();
        if (!$is_reserve) {

            $tables->where('status_table_id', 1);
        }
        $tables = $tables->with('services')->get();

        return compact(
            'services',
            'towers',
            'floors',
            'tables',
            'table_types'
        );
    }
    public function ordenById($id)
    {
        $orden = Orden::find($id);
        return compact('orden');
    }
    function getDateAndTimeToLeave($date, $time, $duration, $is_month_rent)
    {
        if ($is_month_rent) {
            //a $date agregale en meses $duration
            $checkout_date_estimated = Carbon::parse($date)
                ->setTimezone('America/Lima')
                ->addMonths($duration)
                ->format('Y-m-d');
            $checkout_time_estimated = $time;
        } else {
            $configuration = Configuration::first();
            $time_to_leave = $configuration->time_to_leave;
            $time_to_enter = $configuration->time_to_enter;
            $time_to_leave =  Carbon::parse($time_to_leave)
                ->setTimezone('America/Lima')
                ->format('H:i:s');
            $time_to_enter =  Carbon::parse($time_to_enter)
                ->setTimezone('America/Lima')
                ->format('H:i:s');
            $checkout_date_estimated = null;
            $checkout_time_estimated = null;
            if ($duration == 1) {

                if (Carbon::parse($time) < Carbon::parse($time_to_enter)) {
                    $checkout_date_estimated = Carbon::parse($date)
                        ->setTimezone('America/Lima')
                        ->format('Y-m-d');
                } else {
                    $checkout_date_estimated = Carbon::parse($date)
                        ->setTimezone('America/Lima')
                        ->addDay()
                        ->format('Y-m-d');
                }
            } else {
                $checkout_date_estimated = Carbon::parse($date)
                    ->setTimezone('America/Lima')
                    ->addDays($duration)
                    ->format('Y-m-d');
            }
            $checkout_time_estimated = $time_to_leave;
        }
        return [
            'checkout_date_estimated' => $checkout_date_estimated,
            'checkout_time_estimated' => $checkout_time_estimated,
        ];
    }
    public function setGuess(Request $request)
    {
        //     'supplier' => PersonInput::set($inputs['supplier_id']),
        try {
            DB::connection('tenant')->beginTransaction();
            $customer_id = $request->input('customer_id');
            $customer = PersonInput::set($customer_id);
            $advance = $request->input('advance');
            $total = $request->input('total');
            $observation = $request->input('observation');
            $payment_status = "Pendiente";
            $hotel_rent = new HotelRent;
            $hotel_rent->customer_id = $customer_id;
            $hotel_rent->establishment_id = auth()->user()->establishment_id;
            $hotel_rent->user_id = auth()->id();
            $hotel_rent->customer = $customer;
            $hotel_rent->observation = $observation;
            $hotel_rent->payment_status = $payment_status;
            $hotel_rent->advance = $advance;

            $hotel_rent->total = $total;
            $hotel_rent->save();

            $rooms = $request->input('rooms');
            foreach ($rooms as $room) {
                $checkin_date = Carbon::parse($room['checkin_date'])
                    ->setTimezone('America/Lima')
                    ->format('Y-m-d');
                $checkin_time = Carbon::parse($room['checkin_time'])
                    ->setTimezone('America/Lima')
                    ->format('H:i:s');
                $date_estimate_out = $this->getDateAndTimeToLeave($checkin_date, $checkin_time, $room['duration'], $room["is_month_rent"]);
                $hotel_rent_item = new HotelRentItem;
                $hotel_rent_item->hotel_rent_id = $hotel_rent->id;
                $hotel_rent_item->table_id = $room['table_id'];
                $hotel_rent_item->is_reserve = $room['is_reserve'];
                $hotel_rent_item->duration = $room['duration'];
                $hotel_rent_item->is_month_rent = $room['is_month_rent'];

                $hotel_rent_item->advances = $room['advances'];
                $hotel_rent_item->total = $room['total'];
                $hotel_rent_item->quantity_persons = $room['quantity_persons'];
                $hotel_rent_item->payment_status = $payment_status;
                $hotel_rent_item->checkout_date_estimated = $date_estimate_out['checkout_date_estimated'];
                $hotel_rent_item->checkout_time_estimated = $date_estimate_out['checkout_time_estimated'];
                $hotel_rent_item->checkin_date = $checkin_date;
                $hotel_rent_item->checkin_time = $checkin_time;
                $hotel_rent_item->save();
                if ($hotel_rent_item->is_reserve == false) {
                    Table::where('id', $room['table_id'])->update(['status_table_id' => 2]);
                }
                $services = $room['services'];
                foreach ($services as $service) {
                    $hotel_rent_item_service = new HotelRentItemServices;
                    $hotel_rent_item_service->hotel_rent_item_id = $hotel_rent_item->id;
                    $hotel_rent_item_service->room_service_id = $service['id'];
                    $hotel_rent_item_service->quantity = $service['quantity'];
                    $hotel_rent_item_service->code = $this->generate_code();
                    $hotel_rent_item_service->save();

                    event(new PrintEvent($hotel_rent_item_service->id, "H", true));
                }
                $guesses = $room['guesses'];
                foreach ($guesses as $guess) {
                    $hotel_rent_item_person = new HotelRentItemPerson;
                    $hotel_rent_item_person->hotel_rent_item_id = $hotel_rent_item->id;
                    $hotel_rent_item_person->person_id = $guess['id'];
                    $hotel_rent_item_person->save();
                }
            }
            DB::connection('tenant')->commit();

            return [
                'success' => true,
                'message' => 'Habitación actualizada con éxito',
                'id' => $hotel_rent->id
            ];
        } catch (\Exception $e) {
            DB::connection('tenant')->rollBack();
            Log::error($e->getMessage());
            $message = $e->getMessage();
            return [
                'success' => false,
                'message' => $message
            ];
        }
    }
    function generate_code()
    {
        //genera un código de 10 caracteres entre numero, letras mayusculas y minusculas
        $code = Str::random(10);
        return $code;
    }
    public function cancelRoom($id)
    {
        $hotel_rent_item = HotelRentItem::find($id);
        $hotel_rent = $hotel_rent_item->hotel_rent;
        $hotel_rent_item->was_cancel = true;
        $hotel_rent_item->save();
        $table = $hotel_rent_item->table;
        $table->status_table_id = 5;
        $table->sendMessageDesocupied();
        $table->save();
        $items = $hotel_rent->items;
        $cancel = true;
        foreach ($items as $item) {
            if ($item->was_cancel == false) {
                $cancel = false;
            }
        }
        if ($cancel) {
            $hotel_rent->was_cancel = true;
            $hotel_rent->save();
        }
        return [
            'success' => true,
            'message' => 'Habitación cancelada'
        ];
    }
    public function storeType(Request $request, $type)
    {
        $model = null;
        switch ($type) {
            case 'floors':
                $model = new Floor;
                break;
            case 'towers':
                $model = new Tower;
                break;
            default:
                $model = new TableType;
                break;
        }
        $id = $request->input('id');
        $model = $model->firstOrNew(['id' => $id]);
        $model->fill($request->all());
        $model->save();
        return [
            'success' => true,
            'message' => ($id) ? 'Registro actualizado con éxito' : 'Registro creado con éxito'
        ];
    }
    public function get_tables()
    {
        $user = auth()->user();
        $configuration = Configuration::first();
        $time_to_leave = $configuration->alarm_to_end;
        $services = RoomService::where('active', true)->get();
        $establishment_id = $user->establishment_id;
        $tables_types = TableType::where('active', true)->get();
        $this->checkReserves($establishment_id);
        $tables = Table::where('is_room', true)->where(function ($query) {
            $query->where('establishment_id', auth()->user()->establishment_id)->orWhereNull('establishment_id');
        })
            ->get()

            ->transform(function ($row) use ($time_to_leave) {
                $rent_month = false;

                $reserves = HotelRentItem::where('table_id', $row->id)->where('is_reserve', true)
                    ->where('was_cancel', false)
                    ->get()
                    ->transform(function ($rent) {

                        return [
                            'checkin_date' => Carbon::parse($rent->checkin_date)->format('d/m/Y'),
                            'checkin_time' => $rent->checkin_time,

                        ];
                    });
                $table_id = $row->id;
                $counter = null;
                $date_of_out = null;
                if ($row->status_table_id == 2) {
                    //obtener el más reciente hotel_rent_item
                    $hotel_rent_item = HotelRentItem::where('table_id', $table_id)
                        ->where('was_cancel', false)
                        ->orderBy('checkin_date', 'desc')
                        ->orderBy('checkin_time', 'desc')
                        ->first();
                    $rent_month = $hotel_rent_item->is_month_rent;
                    $checkout_date_estimated = $hotel_rent_item->checkout_date_estimated;
                    $checkout_time_estimated = $hotel_rent_item->checkout_time_estimated;

                    $date_of_out = Carbon::parse($checkout_date_estimated . ' ' . $checkout_time_estimated);
                    $date_to_compare  = $date_of_out->copy();
                    $now = Carbon::now()->addMinutes($time_to_leave);
                    if ($now->gt($date_to_compare)) {
                        $counter = true;
                        $date_of_out = $date_of_out
                            ->setTimezone('America/Lima')
                            ->format('Y-m-d H:i:s');
                    }
                }

                return [
                    'rent_month' => $rent_month,
                    'date_of_out' => $date_of_out,
                    'counter' => $counter,
                    'reserves' => $reserves,
                    'cleaning_start_date' => $row->cleaning_start_date,
                    'is_cleaning' => $row->is_cleaning,
                    'is_room' => $row->is_room,
                    'price'            => $row->price,
                    'id'                => $row->id,
                    'number'            => $row->number,
                    'floor_id'          => $row->floor_id,
                    'area'              => $row->area,
                    'type'              => $row->type,
                    'floor'            =>  $row->floor,
                    'status_table'     => $row->status_table,
                    'status_table_id'     => $row->status_table_id,
                    'establishment'     => $row->establishment ? $row->establishment->description : null,
                    'establishment_id'  => $row->establishment_id,
                    'description'      => $row->description,

                ];
            });
        $towers = Tower::where('active', true)->get();
        $floors = Floor::where('active', true)->get();
        $status = StatusTable::where('active', true)->get();
        $reserves = HotelRentItem::where('is_reserve', true)
            ->where('was_cancel', false)
            ->orderBy('checkin_date', 'desc')->orderBy('checkin_time', 'desc')
            ->get()
            ->transform(function ($rent) {
                return [
                    'checkin_date' => Carbon::parse($rent->checkin_date)->format('d/m/Y'),
                    'checkin_time' => $rent->checkin_time,
                    'customer_name' => $rent->hotel_rent->customer->name,
                    'customer_number' => $rent->hotel_rent->customer->number,
                    'room_number' => $rent->table->number,
                    'room_state' => $rent->table->status_table->description,
                    'room_state_id' => $rent->table->status_table_id,
                    'cleaning' => $rent->table->is_cleaning,
                    'tower' => $rent->table->floor->tower->name,
                    'id' => $rent->id,
                    'hotel_rent_id' => $rent->hotel_rent_id,
                ];
            });
        return compact(
            'services',
            'reserves',
            'tables',
            'towers',
            'floors',
            'tables_types',
            'status'
        );
    }
    function transformCustomer($row)
    {
        return [
            'id' => $row->id,
            'description' => $row->number . ' - ' . $row->name,
            'name' => $row->name,
            'number' => $row->number,
            'identity_document_type_id' => $row->identity_document_type_id,
            'identity_document_type_code' => $row->identity_document_type->code,
            'addresses' => $row->addresses,
            'address' =>  $row->address,
            'seller_id' =>  $row->seller_id,
            'phone' => $row->telephone,
        ];
    }
    function transformHotelRentItem($item)
    {
    }
    public function set_reserve_date(Request $request)
    {
        $id = $request->input('id');
        $checkin_date = Carbon::parse($request->input('checkin_date'))
            ->setTimezone('America/Lima')
            ->format('Y-m-d');
        $checkin_time = Carbon::parse($request->input('checkin_time'))
            ->setTimezone('America/Lima')
            ->format('H:i:s');
        $duration = $request->input('duration');
        $table_id = $request->input('table_id');
        $hotel_rent_item = HotelRentItem::find($id);
        $hotel_rent_item->checkin_date = $checkin_date;
        $hotel_rent_item->checkin_time = $checkin_time;
        $hotel_rent_item->duration = $duration;
        $hotel_rent_item->table_id = $table_id;
        $hotel_rent_item->save();
        return [
            'success' => true,
            'message' => 'Fecha de reserva actualizada'
        ];
    }
    public function cancel_reserve($id)
    {
        $hotel_rent_item = HotelRentItem::find($id);
        $hotel_rent_item->was_cancel = true;
        $hotel_rent_item->save();

        return [
            'success' => true,
            'message' => 'Reserva cancelada'
        ];
    }
    public function get_hotel_rent($id)
    {
        $hotel_rent = HotelRent::find($id);
        $customer = $this->transformCustomer(TenantPerson::find($hotel_rent->customer_id));
        $hotel_rent_items = $hotel_rent->items;
        $hotel_rent_items = $hotel_rent_items->transform(function ($row) {
            return [
                'id' => $row->id,

            ];
        });
        return compact('hotel_rent_items', 'customer');
    }
    public function get_reserve_date($id)
    {
        $hotel_rent_item = HotelRentItem::find($id);
        $checkin_date = Carbon::parse($hotel_rent_item->checkin_date)->format('Y-m-d');
        $checkin_time = $hotel_rent_item->checkin_time;
        $duration = $hotel_rent_item->duration;
        $table_id = $hotel_rent_item->table_id;
        return [
            'duration' => $duration,
            'table_id' => $table_id,
            'checkin_date' => $checkin_date,
            'checkin_time' => $checkin_time,
        ];
    }
    public function reserve_to_occupied($id)
    {
        $hotel_rent_item = HotelRentItem::find($id);
        $hotel_rent_item->is_reserve = false;
        $checkin_date = Carbon::now()->format('Y-m-d');
        $checkin_time = Carbon::now()->format('H:i:s');
        $hotel_rent_item->checkin_date = $checkin_date;
        $hotel_rent_item->checkin_time = $checkin_time;
        $hotel_rent_item->save();
        $table = $hotel_rent_item->table;
        $table->status_table_id = 2;
        $table->save();
        return [
            'success' => true,
            'message' => 'Habitación ocupada'
        ];
    }
    public function get_ordens($id)
    {
        $ordens = Orden::where('table_id', $id)->where('status_orden_id', '<>', 4)
            ->where('status_orden_id', '<>', 5)
            ->get();

        return compact('ordens');
    }
    public function records(Request $request)
    {
        $column = $request->input('column');
        $value = $request->input('value');
        // $this->checkReserves();
        $records = Table::where('is_room', true);

        if ($column && $value) {
            $records = $records->where($column, 'like', "%{$value}%");
        }

        return new TableCollection($records->paginate(config('tenant.items_per_page')));

        // return [
        //     'success' => true,
        //     'data' => $tables
        // ];
    }
    function checkReserves($establishment_id)
    {
        $tables_in_reserve = HotelRentItem::where('is_reserve', true)
            ->where('was_cancel', false)
            ->whereNull('checkout_date')
            ->whereNull('checkout_time')
            ->get();

        foreach ($tables_in_reserve as $key => $value) {
            $checkout_date_estimated = Carbon::parse($value->checkout_date_estimated . ' ' . $value->checkout_time_estimated);
            $now = Carbon::now();
            $now->addHours(2);
            if ($checkout_date_estimated->lessThan($now)) {
                $value->was_cancel = true;
                $value->save();
            }
        }
    }
    public function record($id)
    {
        $table = Table::find($id);
        $table->services = $table->services->transform(function ($row) {
            return [
                'room_service_id' => $row->room_service_id,

            ];
        });
        return [
            'success' => true,
            'data' => $table
        ];
    }
    public function get_services($id)
    {
        $hotel_rent_item_service = HotelRentItemServices::where('hotel_rent_item_id', $id)->get()
            ->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'code' => $row->code,
                    'name' => $row->room_service->name,
                    'room_service_id' => $row->room_service_id,
                    'quantity' => $row->quantity,
                    'active' => (bool)$row->active,
                ];
            });

        return [
            'success' => true,
            'data' => $hotel_rent_item_service
        ];
    }
    public function room_types()
    {
        $types = TableType::where('active', true)->get();
        return [
            'success' => true,
            'data' => $types
        ];
    }
    public function check_reserve(Request $request)
    {
        $id = $request->input('id');
        $table_id = $request->input('table_id');
        $duration = $request->input('duration');
        $is_month_rent = $request->input('is_month_rent');
        $checkin_date = Carbon::parse($request->input('checkin_date'))
            ->setTimezone('America/Lima')
            ->format('Y-m-d');
        $checkin_time = Carbon::parse($request->input('checkin_time'))
            ->setTimezone('America/Lima')
            ->format('H:i:s');
        $start_date = Carbon::parse($checkin_date . ' ' . $checkin_time);
        if ($is_month_rent) {
            $end_date = $start_date->copy()->addMonths($duration);
        } else {
            $end_date = $start_date->copy()->addDays($duration);
        }


        $tables_in_reserve = HotelRentItem::where('table_id', $table_id)
            ->whereNull('checkout_date');
        if ($id) {
            $tables_in_reserve->where('id', '<>', $id);
        }

        $tables_in_reserve = $tables_in_reserve->get();
        if ($tables_in_reserve->count() == 0) {
            return [
                'success' => true,
                'message' => 'Habitación disponible'
            ];
        }


        foreach ($tables_in_reserve as $key => $value) {
            $start_date_reserve = Carbon::parse($value->checkin_date . ' ' . $value->checkin_time);
            if ($is_month_rent) {
                $end_date_reserve = $start_date_reserve->copy()->addMonths($value->duration);
            } else {
                $end_date_reserve = $start_date_reserve->copy()->addDays($value->duration);
            }
            if (
                $start_date->between($start_date_reserve, $end_date_reserve) || $end_date->between($start_date_reserve, $end_date_reserve)
                || $start_date_reserve->between($start_date, $end_date) || $end_date_reserve->between($start_date, $end_date)
            ) {
                return [
                    'success' => false,
                    'message' => 'Habitación reservada o en uso | Verifique las fechas/horas de reserva'
                ];
            }
        }
        return [
            'success' => true,
            'message' => 'Habitación disponible'
        ];
    }
    public function store_massive(Request $request)
    {
        $numbers = $request->input('numbers');
        //check in Table if exist the number
        $tables = Table::whereIn('number', $numbers)
            ->where('is_room', true)
            ->where('establishment_id', $request->input('establishment_id'))
            ->where('area_id', $request->input('area_id'))
            ->where('floor_id', $request->input('floor_id'))
            ->get();
        if (count($tables) > 0) {
            return [
                'success' => false,
                'message' => 'Ya existen mesas con los números ingresados'
            ];
        }
        foreach ($numbers as $number) {
            $table = new Table();
            $table->number = $number;
            $table->area_id = $request->input('area_id');
            $table->floor_id = $request->input('floor_id');
            $table->is_room = true;
            $table->status_table_id = $request->input('status_table_id');
            $table->table_type_id = $request->input('table_type_id');
            $table->establishment_id = $request->input('establishment_id');
            $table->price = $request->input('price');
            $table->save();
        }
        return [
            'success' => true,
            'message' => 'Mesas creadas con éxito'
        ];
    }
    public function store(TableRequest $request)
    {
        $id = $request->input('id');
        $table = Table::firstOrNew(['id' => $id]);
        $table->fill($request->all());
        $table->is_room = true;
        $services = $request->input('services');
        TableRoomService::where('table_id', $table->id)->delete();
        $table->save();

        foreach ($services as $service) {
            $table_room_service = new TableRoomService;
            $table_room_service->table_id = $table->id;
            $table_room_service->room_service_id = $service;
            $table_room_service->save();
        }

        return [
            'success' => true,
            'message' => ($id) ? 'Habitación actualizada con éxito' : 'Habitación creada con éxito'
        ];
    }
    public function destroy($id)
    {
        //
    }
}
