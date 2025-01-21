<?php

namespace Modules\Dental\Http\Controllers;

use Modules\Dental\Http\Resources\SpecialtyCollection;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Person;
use Exception;
use Modules\Dental\Http\Resources\SpecialtyResource;
use Modules\Dental\Http\Requests\SpecialtyRequest;
use Modules\Dental\Models\Quoty;
use Modules\Dental\Models\Specialty;

class SpecialtyController extends Controller
{
    public function index()
    {
        return view('dental::specialties.index');
    }
    public function record($id)//Selecccionar un Registro
    {
        $record = new SpecialtyResource(Specialty::findOrFail($id));
        return $record;
    }
    /* public function records(Request $request)
    {
        $records = Specialty::where($request->column, 'like', "%{$request->value}%")->orderBy($request->column,'asc');
        return new SpecialtyCollection($records->paginate(10));     
    } */
    public function records()
    {
        $records = Specialty::all();

        return new SpecialtyCollection($records);
    }

   /* public function tables()
    {
      
     $user= User::all();
     return compact('user');
       
    }*/
    public function store(SpecialtyRequest $request) {
       // $specialty = new Specialty(['description' => $request->input('description')]);
       // $specialty->save();
  //     dd($request->all());
       $specialty = Specialty::firstOrNew(['id' => $request->id]);
       $specialty->fill($request->all());
       $specialty->save();
        return response()->json([
            "success" =>true,
            "message" =>($request->id==null) ? "Se Registro con exito":"Se Actualizo con exito"
            //($request->id!=null) ? "Se Registro con exito";
        ]);
    }
    public function show($id) {
        $specialty = Specialty::find($id);
        return response()->json($specialty);
    }
    public function update($id, Request $request) {
        $specialty = Specialty::find($id);
        $specialty->update($request->all());
        return response()->json([
            "success" =>true,
            "message" =>"Se actualizo con exito"
        ]);
    }
    public function destroy($id) {
        $specialty = Specialty::find($id);
        $specialty->delete();
        return response()->json(
            [
                "success" =>true,
                "message" =>"Se Elimino con exito"
            ]
        );
    }
}
