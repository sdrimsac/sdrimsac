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




    /* public function destroy($id)
    {
        //
    } */
}
