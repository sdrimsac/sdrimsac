<?php

namespace App\Http\Controllers\Tenant;


use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\CommercialTreatmentCollection;
use App\Http\Resources\Tenant\CommercialTreatmentItemCollection;
use App\Http\Resources\Tenant\CommercialTreatmentResource;
use App\Http\Resources\Tenant\PrincipalCategoriesCollection;
use App\Http\Resources\Tenant\PrincipalCategoriesResource;
use App\Models\Tenant\CommercialTreatment;
use App\Models\Tenant\CommercialTreatmentCategory;
use App\Models\Tenant\CommercialTreatmentItem;
use Illuminate\Http\Request;
use Modules\Item\Models\CategoryItem;
use Modules\Item\Models\PrincipalCategory;

class PrincipalCategoryController extends Controller
{
    public function index()
    {
        return view('tenant.principal_categories.index');
    }
    public function columns()
    {
        return [
            'name' => 'Nombre'
        ];
    }
    public function delete($id)
    {
        $principal_category = PrincipalCategory::findOrFail($id);
        $principal_category->delete();
        return [
            'success' => true,
            'message' => 'Eliminado con éxito',
            'data'    => $principal_category
        ];
    }
    
    public function active_desactive($id)
    {
        $principal_category = PrincipalCategory::findOrFail($id);
        $principal_category->active = !$principal_category->active;
        $principal_category->save();
        return [
            'success' => true,
            'message' => 'Actualizado con éxito',
            'data'    => $principal_category
        ];
    }




    public function expanded($id,$expanded){
        $principal_category = PrincipalCategory::findOrFail($id);
        $is_expanded = $expanded == 'true' ? true : false;
        $principal_category->is_expanded = $is_expanded;
        $principal_category->save();
        return [
            'success' => true,
            'message' => 'Actualizado con éxito',
        ];
    }
    public function records(Request $request)
    {
        $all = $request->input('all');
        $records = PrincipalCategory::query();
        if ($request->column == 'name') {
            $records->where('name', 'like', "%{$request->value}%");
        }
        $records =  $records->orderBy('name');
        if ($all) {
            return $records->get();
        }

        return new PrincipalCategoriesCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function record($id)
    {
        $record = new PrincipalCategoriesResource(PrincipalCategory::findOrFail($id));

        return $record;
    }

    public function store(Request $request)
    {
        $id = $request->input('id');
        $principal_category = PrincipalCategory::firstOrNew(['id' => $id]);
        $principal_category->fill($request->all());
        $principal_category->name = strtoupper($request->input('name'));
        $principal_category->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Actualizado con éxito' : 'Registrado con éxito',
            'data'    => $principal_category
        ];
    }
}
