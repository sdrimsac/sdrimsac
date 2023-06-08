<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Requests\Tenant\CategoryRequest;
use App\Http\Resources\Tenant\CategoryCollection;
use App\Http\Resources\Tenant\CategoryResource;
use App\Models\Tenant\Category;
use Exception;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Item;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()                     //Llama al template Blade de laravel
    {
        $configuration = Configuration::first();
        return view('tenant.category.index', compact('configuration'));
    }

    public function columns() //buscador x campo
    {
        return [
            'id'            => 'Código',
            'category'      => 'Categoria',
            //'name2'       => 'Buscador2'
        ];
    }

    public function records(Request $request) //Genera lista de registro para el grid
    {
        $records = Category::where($request->column, 'like', "%{$request->value}%")->orderBy($request->column); //para ordenar

        return new CategoryCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function record($id) //Selecccionar un Registro
    {
        $record = new CategoryResource(Category::findOrFail($id));
        return $record;
    }

    public function store(CategoryRequest $request)
    { //Guardar y Actualizar
        $id          = $request->input('id');
        $category    = Category::firstOrNew(['id' => $id]);
        $category->fill($request->all());
        //$personal->date_nac=Carbon::parse($request->input('date_nac'))->format('Y-m-d');
        $category->save();
        return [
            'success' => true,
            'message' => ($id) ? 'Actualizado con éxito' : 'Registrado con éxito',
            'data'    => $category
        ];
    }

    public function destroy($id) //Eliminar
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return [
            'success' => true,
            'message' => 'Eliminado con éxito'
        ];
    }
}
