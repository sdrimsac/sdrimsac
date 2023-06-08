<?php

namespace App\Http\Controllers\Tenant;
use App\Http\Requests\Tenant\SubcategoryRequest;
use App\Http\Resources\Tenant\SubcategoryCollection;
use App\Http\Resources\Tenant\SubcategoryResource;
use App\Models\Tenant\Subcategory;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index()                     //Llama al template Blade de laravel
    {
        return view('tenant.subcategories.index');
        
    }
    public function columns()//buscador x campo
    {
        return [
            'id'            => 'Código',
            'subcategory'   => 'Subcategoria',
            //'name2'       => 'Buscador2'
        ];
    }
 
    public function records(Request $request)//Genera lista de registro para el grid
    {
     $records = Subcategory::where($request->column, 'like', "%{$request->value}%")->orderBy($request->column);//para ordenar

        return new SubcategoryCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function record($id)//Selecccionar un Registro
    {
        $record = new SubcategoryResource(Subcategory::findOrFail($id));
        return $record;
    }

    public function store(SubcategoryRequest $request){//Guardar y Actualizar
        
        $id          = $request->input('id');
        $subcategory = Subcategory::firstOrNew(['id' => $id]);
        $subcategory->fill($request->all());
        //$personal->date_nac=Carbon::parse($request->input('date_nac'))->format('Y-m-d');
        $subcategory->save();
        return [
            'success' => true,
            'message' => ($id)?'Actualizado con éxito':'Registrado con éxito',
            'data'    =>$subcategory
        ];
    }

    public function destroy($id)//Eliminar
    {
        $subcategory = Subcategory::findOrFail($id);
        $subcategory->delete();
        return [
            'success' => true,
            'message' => 'Eliminado con éxito'
        ];
    }

}
