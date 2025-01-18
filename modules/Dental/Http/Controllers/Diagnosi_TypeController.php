<?php

namespace Modules\Dental\Http\Controllers;


use Modules\Dental\Http\Resources\Diagnosi_TypeCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Dental\Http\Resources\Diagnosi_TypeResource;
use Modules\Dental\Http\Requests\Diagnosi_TypeRequest;
use Modules\Dental\Models\Diagnosis_Types;

class Diagnosi_TypeController extends Controller
{
    public function index() {
        $diagnosi_type = Diagnosis_Types::all()->toArray();
        return array_reverse($diagnosi_type);
    }

    public function columns()
    {
        return [
            'CIE10'       => 'CIE10',  
            'description' => 'description',  
        ];
    }
    public function record($id)//Selecccionar un Registro
    {
        $record = new Diagnosi_TypeResource(Diagnosis_Types::findOrFail($id));
        return $record;
    }
    public function records(Request $request)
    {
        $records = Diagnosis_Types::where($request->column, 'like', "%{$request->value}%")->orderBy($request->column,'asc');
        return new Diagnosi_TypeCollection($records->paginate(4));     
    }
    public function store(Diagnosi_TypeRequest $request) {
      $diagnosi_type = Diagnosis_Types::firstOrNew(['id' => $request->id]);
       $diagnosi_type->fill($request->all());
       $diagnosi_type->save();
        return response()->json([
            "success" =>true,
            "message" =>($request->id==null) ? "Se Registro con exito":"Se Actualizo con exito"
            //($request->id!=null) ? "Se Registro con exito";
        ]);
    }
    public function show($id) {
        $diagnosi_type = Diagnosis_Types::find($id);
        return response()->json($diagnosi_type);
    }
    public function update($id, Request $request) {
        $diagnosi_type = Diagnosis_Types::find($id);
        $diagnosi_type->update($request->all());
        return response()->json([
            "success" =>true,
            "message" =>"Se actualizo con exito"
        ]);
    }
    public function destroy($id) {
        $diagnosi_type = Diagnosis_Types::find($id);
        $diagnosi_type->delete();
        return response()->json(
            [
                "success" =>true,
                "message" =>"Se Elimino con exito"
            ]
        );
    }

}
