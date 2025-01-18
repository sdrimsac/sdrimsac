<?php

namespace Modules\Dental\Http\Controllers;


use Modules\Dental\Http\Resources\TariffCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Category;
use Modules\Dental\Http\Resources\TariffResource;
use Modules\Dental\Http\Requests\TariffRequest;
use Modules\Dental\Models\Tariff;

class TariffController extends Controller
{
    public function index()
    {
        $tariff = Tariff::all()->toArray();
        return array_reverse($tariff);
    }
    public function columns()
    {
        return [
            'category_id'     => 'Categoria',
            'process' => 'Procedimiento',
        ];
    }
    public function record($id) //Selecccionar un Registro
    {
        $record = new TariffResource(Tariff::findOrFail($id));
        return $record;
    }
    public function records(Request $request)
    {

        if ($request->column == 'category_id' && $request->value != null) {
            $category = Category::where('name', 'like', "%{$request->value}%")->first();
            if ($category) {
                $records = Tariff::where('category_id', $category->id)->orderBy($request->column, 'asc');
                return new TariffCollection($records->paginate(20));
            }
        }
        $records = Tariff::where($request->column, 'like', "%{$request->value}%")->orderBy($request->column, 'asc');
        return new TariffCollection($records->paginate(20));
    }

    /* public function tables()
    {
      
     $user= User::all();
     return compact('user');
       
    }*/
    public function store(TariffRequest $request)
    {
        $tariff = Tariff::firstOrNew(['id' => $request->id]);
        $tariff->fill($request->all());
        $tariff->save();
        return response()->json([
            "success" => true,
            "message" => ($request->id == null) ? "Se Registro con exito" : "Se Actualizo con exito"
        ]);
    }
    public function show($id)
    {
        $tariff = Tariff::find($id);
        return response()->json($tariff);
    }
    public function update($id, Request $request)
    {
        $tariff = Tariff::find($id);
        $tariff->update($request->all());
        return response()->json([
            "success" => true,
            "message" => "Se actualizo con exito"
        ]);
    }
    public function destroy($id)
    {
        $tariff = Tariff::find($id);
        $tariff->delete();
        return response()->json(
            [
                "success" => true,
                "message" => "Se Elimino con exito"
            ]
        );
    }
}
