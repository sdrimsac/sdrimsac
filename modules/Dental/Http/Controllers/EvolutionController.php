<?php

namespace Modules\Dental\Http\Controllers;


use Modules\Dental\Http\Resources\EvolutionCollection;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Modules\Dental\Http\Resources\EvolutionResource;
use Modules\Dental\Http\Requests\EvolutionRequest;
use Modules\Dental\Models\Evolution;

class EvolutionController extends Controller
{
    public function index()
    {
        $evolution = Evolution::all()->toArray();
        return array_reverse($evolution);
    }
    public function columns()
    {
        return [
            'patient_id'     => 'Paciente',
            'medic_id'       => 'Medico',
            'date'           => 'Fecha',

        ];
    }
    public function record($id) //Selecccionar un Registro
    {
        $record = new EvolutionResource(Evolution::findOrFail($id));
        return $record;
    }
    public function patient($id) //Selecccionar un Registro
    {
        $records = new EvolutionCollection(Evolution::where('patient_id', $id)->get());
        return [
            'data' => $records,
            'success' => true
        ];
    }

    public function records(Request $request)
    {

        if ($request->column == 'patient_id' && $request->value != null) {
            $evolution = Evolution::where('patient_id', 'like', "%{$request->value}%")->first();
        } else {
            $records = Evolution::where('medic_id', 'like', "%{$request->value}%")->first();
            return new EvolutionCollection($records->paginate(20));
        }
    }

    public function store(EvolutionRequest $request)
    {
        $evolution = Evolution::firstOrNew(['id' => $request->id]);
        $evolution->fill($request->all());
        $evolution->date = Carbon::parse($request->date);
        $evolution->save();
        return response()->json([
            "success" => true,
            "message" => ($request->id == null) ? "Se Registro con exito" : "Se Actualizo con exito"
        ]);
    }
    public function show($id)
    {
        $evolution = Evolution::find($id);
        return response()->json($evolution);
    }
    public function update($id, Request $request)
    {
        $evolution = Evolution::find($id);
        $evolution->update($request->all());
        return response()->json([
            "success" => true,
            "message" => "Se actualizo con exito"
        ]);
    }
    public function destroy($id)
    {
        $evolution = Evolution::find($id);
        $evolution->delete();
        return response()->json(
            [
                "success" => true,
                "message" => "Se Elimino con exito"
            ]
        );
    }
}
