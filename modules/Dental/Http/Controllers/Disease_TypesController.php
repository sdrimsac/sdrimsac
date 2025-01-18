<?php

namespace Modules\Dental\Http\Controllers;


use Modules\Dental\Http\Resources\Disease_TypesCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Modules\Dental\Http\Resources\Disease_TypesResource;
use Modules\Dental\Http\Requests\Disease_TypesRequest;
use Modules\Dental\Models\Disease_types;

class Disease_TypesController extends Controller
{
    public function index() {
        $disease_types = Disease_types::all()->toArray();
        return array_reverse($disease_types);
    }

    public function columns()
    {
        return [
            'description' => 'Descripcion',  
        ];
    }
    public function record($id)//Selecccionar un Registro
    {
        $record = new Disease_TypesResource(Disease_types::findOrFail($id));
        return $record;
    }
    public function records(Request $request)
    {
        $records = Disease_types::where($request->column, 'like', "%{$request->value}%")->orderBy($request->column,'asc');
        return new Disease_TypesCollection($records->paginate(4));     
    }

   /* public function tables()
    {
      
     $user= User::all();
     return compact('user');
       
    }*/
    public function store(Disease_TypesRequest $request) {
       // $specialty = new Specialty(['description' => $request->input('description')]);
       // $specialty->save();
  //     dd($request->all());
       $disease_types = Disease_types::firstOrNew(['id' => $request->id]);
       $disease_types->fill($request->all());
       $disease_types->save();
        return response()->json([
            "success" =>true,
            "message" =>($request->id==null) ? "Se Registro con exito":"Se Actualizo con exito"
            //($request->id!=null) ? "Se Registro con exito";
        ]);
    }
    public function show($id) {
        $disease_types = Disease_types::find($id);
        return response()->json($disease_types);
    }
    public function update($id, Request $request) {
        $disease_types = Disease_types::find($id);
        $disease_types->update($request->all());
        return response()->json([
            "success" =>true,
            "message" =>"Se actualizo con exito"
        ]);
    }
    public function destroy($id) {
        $disease_types = Disease_types::find($id);
        $disease_types->delete();
        return response()->json(
            [
                "success" =>true,
                "message" =>"Se Elimino con exito"
            ]
        );
    }
 
}
