<?php

namespace Modules\Dental\Http\Controllers;


use Modules\Dental\Http\Resources\ConsultationCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Dental\Http\Resources\ConsultationResource;
use Modules\Dental\Http\Requests\ConsultationRequest;

use Modules\Dental\Models\Consultation;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultation = Consultation::all()->toArray();
        return array_reverse($consultation);
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
        $record = new ConsultationResource(Consultation::findOrFail($id));
        return $record;
    }
    public function patient($id) //Selecccionar un Registro
    {
        $record = Consultation::where('patient_id', $id)->first();
        if (!$record) {
            return [
                'success' => false
            ];
        }
        $record = new ConsultationResource($record);
        return [
            'success' => true,
            'data' => $record
        ];
        return $record;
    }
    public function records(Request $request)
    {

        if ($request->column == 'patient_id' && $request->value != null) {
            $consultation = Consultation::where('patient_id', 'like', "%{$request->value}%")->first();
        } else {
            $records = Consultation::where('disease_type_id', 'like', "%{$request->value}%")->first();
            return new ConsultationCollection($records->paginate(20));
        }
    }

    /* public function tables()
    {
      
     $user= User::all();
     return compact('user');
       
    }*/
    public function store(ConsultationRequest $request)
    {
        $consultation = Consultation::firstOrNew(['id' => $request->id]);
        $consultation->fill($request->all());
        $consultation->save();
        return response()->json([
            "success" => true,
            "message" => ($request->id == null) ? "Se Registro con exito" : "Se Actualizo con exito"
        ]);
    }
    public function show($id)
    {
        $consultation = Consultation::find($id);
        return response()->json($consultation);
    }
    public function update($id, Request $request)
    {
        $consultation = Consultation::find($id);
        $consultation->update($request->all());
        return response()->json([
            "success" => true,
            "message" => "Se actualizo con exito"
        ]);
    }
    public function destroy($id)
    {
        $consultation = Consultation::find($id);
        $consultation->delete();
        return response()->json(
            [
                "success" => true,
                "message" => "Se Elimino con exito"
            ]
        );
    }
}
