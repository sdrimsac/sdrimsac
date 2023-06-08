<?php

namespace App\Http\Controllers\Tenant;
use App\Http\Requests\Tenant\GroupRequest;
use App\Http\Resources\Tenant\GroupCollection;
use App\Http\Resources\Tenant\GroupResource;
use App\Models\Tenant\Group;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
class GroupController extends Controller
{
    public function index()                     //Llama al template Blade de laravel
    {
        return view('tenant.groups.index');
        
    }
    public function columns()//buscador x campo
    {
        return [
            'id'            => 'Código',
            'group'         => 'Grupo',
            //'name2'       => 'Buscador2'
        ];
    }
 
    public function records(Request $request)//Genera lista de registro para el grid
    {
     $records = Group::where($request->column, 'like', "%{$request->value}%")->orderBy($request->column);//para ordenar

        return new GroupCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function record($id)//Selecccionar un Registro
    {
        $record = new GroupResource(Group::findOrFail($id));
        return $record;
    }

    public function store(GroupRequest $request){//Guardar y Actualizar
        $id       = $request->input('id');
        $group    = Group::firstOrNew(['id' => $id]);
        $group->fill($request->all());
        //$personal->date_nac=Carbon::parse($request->input('date_nac'))->format('Y-m-d');
        $group->save();
        return [
            'success' => true,
            'message' => ($id)?'Actualizado con éxito':'Registrado con éxito',
            'data'    =>$group
        ];
    }

    public function destroy($id)//Eliminar
    {
        $group = Group::findOrFail($id);
        $group->delete();
        return [
            'success' => true,
            'message' => 'Eliminado con éxito'
        ];
    }
}
