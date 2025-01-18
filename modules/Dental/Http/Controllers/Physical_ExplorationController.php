<?php

namespace Modules\Dental\Http\Controllers;


use Modules\Dental\Http\Resources\OdontogramCollection;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Modules\Dental\Http\Resources\Physical_ExplorationResource;
use Modules\Dental\Http\Requests\Physical_ExplorationRequest;
use Modules\Dental\Models\Physical_Exploration;

class Physical_ExplorationController extends Controller
{
    public function index()
    {
        $physical = Physical_Exploration::all()->toArray();
        return array_reverse($physical);
    }
    public function columns()
    {
        return [
            'patient_id' => 'Paciente',

        ];
    }
    public function record($id) //Selecccionar un Registro
    {
        $record = new Physical_ExplorationResource(Physical_Exploration::findOrFail($id));
        return $record;
    }
    public function patient($id) //Selecccionar un Registro
    {
        $record =  Physical_Exploration::where('patient_id', $id)->first();

        if (!$record) {
            return [
                'success' => false
            ];
        }
        $record = new Physical_ExplorationResource($record);
        return [
            'success' => true,
            'data' => $record
        ];
        return $record;
    }
    public function records(Request $request)
    {

        $records = Physical_Exploration::where($request->column, '=', "%{$request->value}%")->orderBy($request->column, 'asc');
        return new Physical_Exploration($records->paginate(20));
    }

    public function store(Physical_ExplorationRequest $request)
    {
        $physical = Physical_Exploration::firstOrNew(['id' => $request->id]);
        $physical->fill($request->all());
        $physical->save();
        return response()->json([
            "success" => true,
            "message" => ($request->id == null) ? "Se Registro con exito" : "Se Actualizo con exito"
        ]);
    }
    public function show($id)
    {
        $physical = Physical_Exploration::find($id);
        return response()->json($physical);
    }
    public function update($id, Request $request)
    {
        $physical = Physical_Exploration::find($id);
        $physical->update($request->all());
        return response()->json([
            "success" => true,
            "message" => "Se actualizo con exito"
        ]);
    }
    public function destroy($id)
    {
        $physical = Physical_Exploration::find($id);
        $physical->delete();
        return response()->json(
            [
                "success" => true,
                "message" => "Se Elimino con exito"
            ]
        );
    }
}
