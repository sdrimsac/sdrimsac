<?php

namespace Modules\Dental\Http\Controllers;


use Modules\Dental\Http\Resources\Allergies_TypesCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Dental\Http\Resources\Allergies_TypesResource;
use Modules\Dental\Http\Requests\Allergies_TypesRequest;

use Modules\Dental\Models\Allergies_Types;

class Allergies_TypesController extends Controller
{
    public function index()
    {
        $allergies_types = Allergies_Types::all()->toArray();
        return array_reverse($allergies_types);
    }
    public function columns()
    {
        return [
            'description'  => 'Descripción',


        ];
    }
    public function record($id) //Selecccionar un Registro
    {
        $record = new Allergies_TypesResource(Allergies_Types::findOrFail($id));
        return $record;
    }
    public function records(Request $request)
    {

        // $records = Allergies_Types::where($request->column, 'like', "%{$request->value}%")->orderBy($request->column,'asc');
        return new Allergies_TypesCollection(Allergies_Types::paginate(20));
    }

    public function store(Allergies_TypesRequest $request)
    {
        $allergies_types = Allergies_Types::firstOrNew(['id' => $request->id]);
        $allergies_types->fill($request->all());
        $allergies_types->save();
        return response()->json([
            "success" => true,
            "message" => ($request->id == null) ? "Se Registro con exito" : "Se Actualizo con exito"
        ]);
    }
    public function show($id)
    {
        $allergies_types = Allergies_Types::find($id);
        return response()->json($allergies_types);
    }
    public function update($id, Request $request)
    {
        $allergies_types = Allergies_Types::find($id);
        $allergies_types->update($request->all());
        return response()->json([
            "success" => true,
            "message" => "Se actualizo con exito"
        ]);
    }
    public function destroy($id)
    {
        $allergies_types = Allergies_Types::find($id);
        $allergies_types->delete();
        return response()->json(
            [
                "success" => true,
                "message" => "Se Elimino con exito"
            ]
        );
    }
}
