<?php

namespace Modules\Dental\Http\Controllers;


use Modules\Dental\Http\Resources\OdontogramCollection;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Modules\Dental\Http\Resources\OdontogramResource;
use Modules\Dental\Http\Requests\EvolutionRequest;
use Modules\Dental\Models\Odontogram;

class OdontogramController extends Controller
{


    public function record($id) //Selecccionar un Registro
    {
        $record = new OdontogramResource(Odontogram::findOrFail($id));
        return $record;
    }
    public function patient($id) //Selecccionar un Registro
    {
        $records = new OdontogramCollection(Odontogram::where('patient_id', $id)->get());
        return [
            'data' => $records,
            'success' => true
        ];
    }
    public function records(Request $request)
    {

        if ($request->column == 'patient_id' && $request->value != null) {
            $Odontogram = Odontogram::where('patient_id', 'like', "%{$request->value}%")->first();
        } else {
            $records = Odontogram::where('Odontogram_type_id', 'like', "%{$request->value}%")->first();
            return new OdontogramCollection($records->paginate(20));
        }
    }

    public function store(Request $request)
    {
        $Odontogram = Odontogram::firstOrNew(['tooth' => $request->tooth], [
            'patient_id' => $request->patient_id
        ]);
        $Odontogram->fill($request->all());
        $Odontogram->save();
        return response()->json([
            "success" => true,
            "message" => "Se Registro con exito"
        ]);
    }

    public function update($id, Request $request)
    {
        $Odontogram = Odontogram::find($id);
        $Odontogram->update($request->all());
        return response()->json([
            "success" => true,
            "message" => "Se actualizo con exito"
        ]);
    }
    public function destroy($id)
    {
        $Odontogram = Odontogram::find($id);
        $Odontogram->delete();
        return response()->json(
            [
                "success" => true,
                "message" => "Se Elimino con exito"
            ]
        );
    }
}
