<?php

namespace Modules\Restaurant\Http\Controllers;


use App\Models\Tenant\Configuration;
use Illuminate\Http\Request;
use Modules\Restaurant\Models\Area;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Models\Table;
use Modules\Restaurant\Models\Casino;
use Modules\Restaurant\Http\Requests\TableRequest;
use Modules\Restaurant\Http\Resources\TableCollection;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\OrdenItem;
use App\Events\MessageEvent;
use Illuminate\Support\Carbon;

class CasinoController extends Controller
{
    public function index()
    {
        $configurations = Configuration::first();
        return view('restaurant::configuration.tables', compact('configurations'));
    }
    public function columns()
    {
        return [
            'number' => 'Nº Mesa',
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'reference' => 'required|string',
        ]);

        $table_id = auth()->user()->table_id;

        $date_start = Carbon::now()->toDateString();

        $time_start = Carbon::now()->toTimeString();

        $minutes = 0;

        $casino = Casino::create([
            'table_id' => $table_id,
            'date_start' => $date_start,  
            'time_start' => $time_start,  
            'minutes' => $minutes,
            'reference' => $request->reference,
        ]);

        return response()->json([
            'message' => 'Datos guardados exitosamente',
            'data' => $casino,
        ], 201);
    }

    public  function desocupied($id)
    {
        $hotel_rent_item = Casino::find($id);
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
            'message' => 'Mesa desocupada'
        ];
    }




    /* public function destroy($id)
    {
        //
    } */
}
