<?php

namespace Modules\Restaurant\Http\Controllers;


use App\Models\Tenant\Configuration;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Restaurant\Models\Table;
use Modules\Restaurant\Http\Requests\TableRequest;
use Modules\Restaurant\Http\Resources\TableCollection;
use Modules\Restaurant\Models\Orden;

class TableController extends Controller
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
    public function recordsByArea($id)
    {
        $establishment_id = auth()->user()->establishment_id;
        $tables = new TableCollection(Table::where('area_id', $id)
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
    public function get_tables()
    {
        $user = auth()->user();
        $establishment_id = $user->establishment_id;
        $this->checkTables($establishment_id);
        $tables = Table::where('establishment_id', $establishment_id)->orWhereNull('establishment_id')
            ->get();

        return compact('tables');
    }
    public function get_ordens($id)
    {
        $ordens = Orden::where('table_id', $id)->where('status_orden_id', '<>', 4)->get();

        return compact('ordens');
    }
    public function records()
    {
        $this->checkTables();
        $records = Table::query();
        return new TableCollection($records->paginate(config('tenant.items_per_page')));

        // return [
        //     'success' => true,
        //     'data' => $tables
        // ];
    }
    function checkTables($establishment_id)
    {
    
        Table::where('status_table_id', 2)
        ->where('establishment_id', $establishment_id)
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
    public function store_massive(Request $request)
    {
        $numbers = $request->input('numbers');
        //check in Table if exist the number
        $tables = Table::whereIn('number', $numbers)
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
            $table->status_table_id = $request->input('status_table_id');
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
        $table->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Área actualizada con éxito' : 'Área creada con éxito'
        ];
    }
    public function destroy($id)
    {
        //
    }
}
