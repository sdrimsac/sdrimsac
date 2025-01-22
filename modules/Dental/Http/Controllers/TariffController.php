<?php

namespace Modules\Dental\Http\Controllers;


use Modules\Dental\Http\Resources\TariffCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Category;
use COM;
use Modules\Dental\Http\Resources\TariffResource;
use Modules\Dental\Http\Requests\TariffRequest;
use Modules\Dental\Models\Tariff;
use Modules\Item\Models\CategoryItem;

class TariffController extends Controller
{
    public function index()
    {
        return view('dental::tariffs.index');
    }
    /* public function columns()
    {
        return [
            'category_id'     => 'Categoria',
            'process' => 'Procedimiento',
        ];
    } */
    public function record($id) //Selecccionar un Registro
    {
        $record = new TariffResource(Tariff::findOrFail($id));
        return $record;
    }
    /* public function records(Request $request)
    {

        $records = Tariff::where($request->column, 'like', "%{$request->value}%")->orderBy($request->column, 'asc');
        return new TariffCollection($records->paginate(20));
    } */
    public function records()
    {
        $records = Tariff::all();

        return new TariffCollection($records);
    }

    public function store(Request $request)
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
    /* public function tables()
    {
        $categories = Category::all();
        return $categories;
    } */
    public function tables()
    {
        $categories = CategoryItem::orderBy('name')->get();

        return compact(
            'categories',
        );
    }
}
