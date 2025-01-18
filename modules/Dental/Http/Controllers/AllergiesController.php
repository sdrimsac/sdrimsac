<?php

namespace Modules\Dental\Http\Controllers;


use Modules\Dental\Http\Resources\AllergiesCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Dental\Http\Resources\AllergiesResource;
use Modules\Dental\Http\Requests\AllergiesRequest;

use Modules\Dental\Models\Allergies;

class AllergiesController extends Controller
{
    public function index()
    {
        $allergies = Allergies::all()->toArray();
        return array_reverse($allergies);
    }
    public function columns()
    {
        return [
            'patient_id'            => 'Paciente',
            'allergies_types_id'    => 'Alergias',
            
        ];
    }
    public function record($id) //Selecccionar un Registro
    {
        $record = new AllergiesResource(Allergies::findOrFail($id));
        return $record;
    }
    public function records(Request $request)
    {
        if ($request->column == 'patient_id' && $request->value != null) {
            $allergies = Allergies::where('patient_id', 'like', "%{$request->value}%")->first();
        }else {
                $records = Allergies::where('allergies_types_id','like', "%{$request->value}%")->first();
                return new AllergiesCollection($records->paginate(20));
            }
        
    }

    public function store(AllergiesRequest $request)
    {
        $allergies = Allergies::firstOrNew(['id' => $request->id]);
        $allergies->fill($request->all());
        $allergies->save();
        return response()->json([
            "success" => true,
            "message" => ($request->id == null) ? "Se Registro con exito" : "Se Actualizo con exito"
        ]);
    }
    public function show($id)
    {
        $allergies = Allergies::find($id);
        return response()->json($allergies);
    }
    public function update($id, Request $request)
    {
        $allergies = Allergies::find($id);
        $allergies->update($request->all());
        return response()->json([
            "success" => true,
            "message" => "Se actualizo con exito"
        ]);
    }
    public function destroy($id)
    {
        $allergies = Allergies::find($id);
        $allergies->delete();
        return response()->json(
            [
                "success" => true,
                "message" => "Se Elimino con exito"
            ]
        );
    }
    
}
