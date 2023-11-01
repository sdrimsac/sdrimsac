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
use Modules\Restaurant\Models\Floor;
use Modules\Restaurant\Models\Food;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\OrdenItem;
use Modules\Restaurant\Models\TableType;
use Modules\Restaurant\Models\Tower;

class TableRoomController extends Controller
{


    public function deleteItem($type, $id){
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
        $price = $table->type->price;
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
    public function sendToclean($id)
    {
        $table = Table::find($id);
        $table->is_cleaning = true;
        $table->cleaning_start_date = Carbon::now()->addMinutes(2);
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
        $item = Item::where('unit_type_id', 'ZZ')->first();
        if ($item) {
            $food = Food::where('item_id', $item->id)->first();
            return $food;
        } else {
            $configuration = Configuration::first();
            $affectation_igv_type_id = $configuration->affectation_igv_type_id;
            $item = Item::create([
                [
                    'item_type_id' => '01',
                    'unit_type_id' => 'ZZ',
                    'internal_id' => '000ZZ',
                    'description' => 'Servicio',
                    'currency_type_id' => 'PEN',
                    'sale_unit_price' => '1.00',
                    'sale_affectation_igv_type_id'  => $affectation_igv_type_id,
                    'purchase_affectation_igv_type_id' => $affectation_igv_type_id,
                ]
            ]);
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
    function recalculate(HotelRentItem $hote_rent_item){
        $table = $hote_rent_item->table;
        $price = $table->type->price;
        $total = $price * $hote_rent_item->duration;
        $hote_rent_item->total = $total;
        $hote_rent_item->save();
        $hotel_rent = $hote_rent_item->hotel_rent;
        $hotel_rent->total = $hotel_rent->items->sum('total');
        $hotel_rent->save();
    }
    public function changeRoom($to,$from){
        $table_to = Table::find($to);
        $hotel_rent_item = HotelRentItem::where('table_id',$to)->orderBy('id','desc')->first();
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
    public  function allOrdens(Request $request,$id)
    {   
        $extra_time = $request->input('extra_time') ?? 0;
        $hotel_rent_item = HotelRentItem::find($id);
        $hotel_rent_item->extra_time = $extra_time;
        $hotel_rent_item->save();
        $customer_number  = $hotel_rent_item->hotel_rent->customer->number;
        $hotel_rent = $hotel_rent_item->hotel_rent;
        $hotel_rent_id = $hotel_rent->id;
        $single_room = $hotel_rent->items->count() == 1;
        $hotel_rent_item_id = $id;
        $total =  $hotel_rent_item->total;
        $description = $this->create_description($hotel_rent_item);
        $extra_service = null;
        $service = $this->get_item_service();
        if($extra_time>0){
            $extra_service = $this->get_item_service();
            $extra_service->price = $extra_time;
            $extra_service->description = "Tiempo extra";
            $extra_service->item->description = "Tiempo extra";
        }
        $service->price = $total;
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
        if($extra_service){
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
    public function tables()
    {
        $table_types = TableType::where('active', true)->get();
        $towers = Tower::where('active', true)->get();
        $floors = Floor::where('active', true)->get();
        $tables = Table::where('is_room', true)
            ->where('status_table_id', 1)
            ->get();

        return compact('towers', 'floors', 'tables','table_types');
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
                $hotel_rent_item = new HotelRentItem;
                $hotel_rent_item->hotel_rent_id = $hotel_rent->id;
                $hotel_rent_item->table_id = $room['table_id'];
                $hotel_rent_item->duration = $room['duration'];
                $hotel_rent_item->total = $room['total'];
                $hotel_rent_item->quantity_persons = $room['quantity_persons'];
                $hotel_rent_item->payment_status = $payment_status;
                $hotel_rent_item->checkin_date = Carbon::parse($room['checkin_date'])->format('Y-m-d');
                $hotel_rent_item->checkin_time = Carbon::parse($room['checkin_time'])->format('H:i:s');
                $hotel_rent_item->save();
                Table::where('id', $room['table_id'])->update(['status_table_id' => 2]);

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
                'message' => 'Habitación actualizada con éxito'
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
    public function storeType(Request $request,$type){
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
            ->get();
        $towers = Tower::where('active', true)->get();
        $floors = Floor::where('active', true)->get();

        return compact('tables', 'towers', 'floors','tables_types');
    }
    public function get_ordens($id)
    {
        $ordens = Orden::where('table_id', $id)->where('status_orden_id', '<>', 4)
            ->where('status_orden_id', '<>', 5)
            ->get();

        return compact('ordens');
    }
    public function records()
    {

        // $this->checkTables();
        $records = Table::where('is_room', true);
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
                        // $ordens = Orden::where('table_id', $table->id)->where('status_orden_id', '<>', 4)->where('status_orden_id', '<>', 5)->get();

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
    public function store_massive(Request $request)
    {
        $numbers = $request->input('numbers');
        //check in Table if exist the number
        $tables = Table::whereIn('number', $numbers)
            ->where('is_room', true)
            ->where('establishment_id', $request->input('establishment_id'))
            ->where('area_id', $request->input('area_id'))
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
            $table->table_type_id = $request->input('status_table_id');
            $table->establishment_id = $request->input('establishment_id');
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
