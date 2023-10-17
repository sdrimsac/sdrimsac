<?php

namespace Modules\Restaurant\Http\Controllers;

use App\CoreFacturalo\Requests\Inputs\Common\PersonInput;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\HotelRent;
use App\Models\Tenant\HotelRentItem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Restaurant\Models\Table;
use Modules\Restaurant\Http\Requests\TableRequest;
use Modules\Restaurant\Http\Resources\TableCollection;
use Modules\Restaurant\Models\Floor;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\OrdenItem;
use Modules\Restaurant\Models\TableType;
use Modules\Restaurant\Models\Tower;

class TableRoomController extends Controller
{


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
    public function tables()
    {
        $towers = Tower::where('active', true)->get();
        $floors = Floor::where('active', true)->get();
        $tables = Table::where('is_room', true)
            ->where('status_table_id', 1)
            ->get();

        return compact('towers', 'floors', 'tables');
    }
    public function setGuess(Request $request){
        //     'supplier' => PersonInput::set($inputs['supplier_id']),
        $customer_id = $request->input('customer_id');
        $customer = PersonInput::set($customer_id);
        $advance = $request->input('advance');
        $total = $request->input('total');
        $observation = $request->input('observation');
        $payment_status = "Pendiente";
        $hotel_rent = new HotelRent;
        $hotel_rent->customer_id = $customer_id;
        $hotel_rent->customer = $customer;
        $hotel_rent->observation = $observation;
        $hotel_rent->payment_status = $payment_status;
        $hotel_rent->advance = $advance;
        $hotel_rent->total = $total;
        $hotel_rent->save();

        $rooms = $request->input('rooms');
        foreach($rooms as $room){
            $hotel_rent_item = new HotelRentItem;
            $hotel_rent_item->hotel_rent_id = $hotel_rent->id;
            $hotel_rent_item->table_id = $room['table_id'];
            

        }
       

        return [
            'success' => true,
            'message' => 'Habitación actualizada con éxito'
        ];
    }
    public function get_tables()
    {
        $user = auth()->user();
        $establishment_id = $user->establishment_id;
        $this->checkTables($establishment_id);
        $tables = Table::where('is_room', true)->where('establishment_id', $establishment_id)->orWhereNull('establishment_id')
            ->get();

        return compact('tables');
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
