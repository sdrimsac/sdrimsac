<?php

namespace Modules\Restaurant\Http\Controllers;

use App\CoreFacturalo\Requests\Inputs\Common\PersonInput;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\HotelRent;
use App\Models\Tenant\HotelRentItem;
use App\Models\Tenant\HotelRentItemPerson;
use App\Models\Tenant\Item;
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
use Modules\Restaurant\Models\CategoryFood;
use Modules\Restaurant\Models\DetailTable;
use Modules\Restaurant\Models\Floor;
use Modules\Restaurant\Models\Food;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\OrdenItem;
use Modules\Restaurant\Models\StatusTable;
use Modules\Restaurant\Models\TableType;
use Modules\Restaurant\Models\Tower;

class TableRoomController extends Controller
{


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
        $price = $table->price;
        $total = $price * $days;
        $hotel_rent_item->total = $total;
        $hotel_rent->total -= $old_total;
        $hotel_rent->total += $total;
        $hotel_rent->save();
        $hotel_rent_item->save();
        return [
            'success' => true,
            'message' => 'Días agregados'
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
        $table->status_table_id = 1;
        $table->save();
        return [
            'success' => true,
            'message' => 'Habitación disponible'
        ];
    }
    public function sendToMaintenance($id)
    {
        $table = Table::find($id);
        $table->status_table_id = 3;
        $table->save();
        return [
            'success' => true,
            'message' => 'Habitación enviada a mantenimiento'
        ];
    }
    public function sendToclean($id)
    {   $configuration = Configuration::first();
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
        $room = HotelRentItem::where('table_id', $id)->where('payment_status', 'Pendiente')->first();


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
            $service->description = "Adelanto de habitación n° " . $hotel_rent_item->table->number;
            $service->item->description = "Adelanto de habitación n° " . $hotel_rent_item->table->number;
            $items->push([
                'id' => 0,
                'observation' => '',
                'food' => $service,
                'quantity' => 1,
                'price' => number_format($service->price, 2),
            ]);
        }
        return compact(
            'items',
            'hotel_rent_id',
            'customer_number'
        );
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
            'price' => number_format($service->price, 2),
        ]);
        if ($extra_service) {
            $ordens_items->push([
                'id' => 0,
                'observation' => '',
                'food' => $extra_service,
                'quantity' => 1,
                'price' => number_format($extra_service->price, 2),
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
        if (!$is_reserve) {

            $tables->where('status_table_id', 1);
        }
        $tables = $tables->get();

        return compact('towers', 'floors', 'tables', 'table_types');
    }
    public function ordenById($id)
    {
        $orden = Orden::find($id);
        return compact('orden');
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
                $hotel_rent_item = new HotelRentItem;
                $hotel_rent_item->hotel_rent_id = $hotel_rent->id;
                $hotel_rent_item->table_id = $room['table_id'];
                $hotel_rent_item->is_reserve = $room['is_reserve'];
                $hotel_rent_item->duration = $room['duration'];
                $hotel_rent_item->advances = $room['advances'];
                $hotel_rent_item->total = $room['total'];
                $hotel_rent_item->quantity_persons = $room['quantity_persons'];
                $hotel_rent_item->payment_status = $payment_status;
                $hotel_rent_item->checkin_date = $checkin_date;
                $hotel_rent_item->checkin_time = $checkin_time;
                $hotel_rent_item->save();
                if ($hotel_rent_item->is_reserve == false) {
                    Table::where('id', $room['table_id'])->update(['status_table_id' => 2]);
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
    public function cancelRoom($id){
        $hotel_rent_item = HotelRentItem::find($id);
        $hotel_rent = $hotel_rent_item->hotel_rent;
        $hotel_rent_item->was_cancel = true;
        $hotel_rent_item->save();
        $table = $hotel_rent_item->table;
        $table->status_table_id = 5;
        $table->save();
        $items = $hotel_rent->items;
        $cancel = true;
        foreach ($items as $item) {
            if($item->was_cancel == false){
                $cancel = false;
            }
        }
        if($cancel){
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
        $establishment_id = $user->establishment_id;
        $tables_types = TableType::where('active', true)->get();
        // $this->checkTables($establishment_id);
        $tables = Table::where('is_room', true)->where(function ($query) {
            $query->where('establishment_id', auth()->user()->establishment_id)->orWhereNull('establishment_id');
        })
            ->get()

            ->transform(function ($row) {

                $reserves = HotelRentItem::where('table_id', $row->id)->where('is_reserve', true)
                    ->get()
                    ->transform(function ($rent) {

                        return [
                            'checkin_date' => Carbon::parse($rent->checkin_date)->format('d/m/Y'),
                            'checkin_time' => $rent->checkin_time,

                        ];
                    });
                return [
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
        $reserves = HotelRentItem::where('is_reserve', true)->orderBy('checkin_date','desc')->orderBy('checkin_time','desc')
            ->get()
            ->transform(function ($rent) {
                return [
                    'checkin_date' => Carbon::parse($rent->checkin_date)->format('d/m/Y'),
                    'checkin_time' => $rent->checkin_time,
                    'customer_name' => $rent->hotel_rent->customer->name,
                    'customer_number' => $rent->hotel_rent->customer->number,
                    'room_number' => $rent->table->number,
                    'tower' => $rent->table->floor->tower->name,
                ];
            });
        return compact('reserves','tables', 'towers', 'floors', 'tables_types', 'status');
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
        // $this->checkTables();
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
    function checkTables($establishment_id)
    {

        Table::where('status_table_id', 2)
            ->where('is_room', true)
            ->where('establishment_id', $establishment_id)->orWhereNull('establishment_id')
            ->chunk(
                50,
                function ($row) {
                    foreach ($row as $table) {
                        //buscar las ordenes de la mesa
                        $ordens = Orden::where('table_id', $table->id)->where('status_orden_id', '<>', 4)->where('status_orden_id', '<>', 5)->get();

                        if (count($ordens) == 0) {
                            $table->status_table_id = 1;
                            $table->save();
                        }
                    }
                }
            );
    }
    public function record($id)
    {
        $table = Table::find($id);

        return [
            'success' => true,
            'data' => $table
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
        $table_id = $request->input('table_id');
        $duration = $request->input('duration');
        $checkin_date = Carbon::parse($request->input('checkin_date'))
            ->setTimezone('America/Lima')
            ->format('Y-m-d');
        $checkin_time = Carbon::parse($request->input('checkin_time'))
            ->setTimezone('America/Lima')
            ->format('H:i:s');
        $start_date = Carbon::parse($checkin_date . ' ' . $checkin_time);
        $end_date = $start_date->copy()->addDays($duration);


        $tables_in_reserve = HotelRentItem::where('table_id', $table_id)
            ->whereNull('checkout_date')
            ->get();
        if ($tables_in_reserve->count() == 0) {
            return [
                'success' => true,
                'message' => 'Habitación disponible'
            ];
        }


        foreach ($tables_in_reserve as $key => $value) {
            $start_date_reserve = Carbon::parse($value->checkin_date . ' ' . $value->checkin_time);
            $end_date_reserve = $start_date_reserve->copy()->addDays($value->duration);

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
        $table->save();

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
