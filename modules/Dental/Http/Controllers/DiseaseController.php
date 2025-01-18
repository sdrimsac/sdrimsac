<?php

namespace Modules\Dental\Http\Controllers;


use Modules\Dental\Http\Resources\DiseaseCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Dental\Http\Resources\DiseaseResource;
use Modules\Dental\Http\Requests\DiseaseRequest;
use Modules\Dental\Models\Disease;

class DiseaseController extends Controller
{
    public function index()
    {
        $disease = Disease::all()->toArray();
        return array_reverse($disease);
    }
    public function columns()
    {
        return [
            'patient_id'            => 'Paciente',
            'disease_type_id'       => 'Tipo de Enfermedad',

        ];
    }
    public function record($id) //Selecccionar un Registro
    {
        $record = new DiseaseResource(Disease::findOrFail($id));
        return $record;
    }
    public function patient($id) //Selecccionar un Registro
    {
        $record = Disease::where('patient_id', $id)->first();
        if (!$record) {
            return [
                'success' => false
            ];
        }
        $record = new DiseaseResource($record);
        return [
            'success' => true,
            'data' => $record
        ];
    }
    public function records(Request $request)
    {

        if ($request->column == 'patient_id' && $request->value != null) {
            $disease = Disease::where('patient_id', 'like', "%{$request->value}%")->first();
        } else {
            $records = Disease::where('disease_type_id', 'like', "%{$request->value}%")->first();
            return new DiseaseCollection($records->paginate(20));
        }
    }

    public function store(DiseaseRequest $request)
    {
        $disease = Disease::firstOrNew(['id' => $request->id]);
        $disease->fill($request->all());
        $disease->save();
        return response()->json([
            "success" => true,
            "message" => ($request->id == null) ? "Se Registro con exito" : "Se Actualizo con exito"
        ]);
    }
    public function show($id)
    {
        $disease = Disease::find($id);
        return response()->json($disease);
    }
    public function update($id, Request $request)
    {
        $disease = Disease::find($id);
        $disease->update($request->all());
        return response()->json([
            "success" => true,
            "message" => "Se actualizo con exito"
        ]);
    }
    public function destroy($id)
    {
        $disease = Disease::find($id);
        $disease->delete();
        return response()->json(
            [
                "success" => true,
                "message" => "Se Elimino con exito"
            ]
        );
    }
}
