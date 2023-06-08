<?php

namespace Modules\Restaurant\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Tenant\Configuration;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Http\Resources\BoxesItemDetailCollection;
use Modules\Restaurant\Models\BoxesDetail;
use Modules\Restaurant\Models\BoxesItemDetail;

class BoxesDetailController extends Controller
{

    public function save_item(Request $request)
    {
        $description = strtoupper($request->description);
        $unit_type_id = strtoupper($request->unitTypeId);
        $exist = BoxesItemDetail::where('detail', $description)->where('unit_id', $unit_type_id)->first();

        if ($exist) {
            return ["success" => false, "message" => "Ya existe el registro"];
        }
        $created = new BoxesItemDetail([
            "detail" => $description,
            "unit_id" => $unit_type_id
        ]);
        $created->save();
        return ["success" => true, "message" => "Se guardó exitosamente", "item" => $created];
    }
    public function index()
    {
        $configurations = Configuration::first();
        return view('restaurant::configuration.areas', compact('configurations'));
    }
    public function columns()
    {
        return [
            'description' => 'Descripción',
            'active'      => 'Estado'
        ];
    }
    public function records(Request $request)
    {

        if ($request->value == "Activado") {
            $records = BoxesDetail::where($request->column, '=', 1);
        } else {
            $records = BoxesDetail::where($request->column, 'like', "%{$request->value}%");
        }
        return  $records->paginate(config('tenant.items_per_page'));
    }
    public function actives()
    {
        $areas = BoxesDetail::where('active', 1)->get();

        return [
            'success' => true,
            'data' => $areas
        ];
    }
    public function active($id)
    {
        $area = BoxesDetail::find($id);
        $area->active = !$area->active;
        $area->save();
        return [
            'success' => true,
            'data' => $area,
            'message' => 'Área ' . ($area->active ? 'activada' : 'desactivada')
        ];
    }
    public function record($id)
    {
        $area = BoxesDetail::find($id);

        return [
            'success' => true,
            'data' => $area
        ];
    }
    public function items_detail(Request $request)
    {
        $description = $request->description;
        $records = BoxesItemDetail::query();

        if ($description) {
            $records = $records->where('detail', 'like', '%' . $description . '%');
        }
        $records = $records->get()->take(15);
        return new BoxesItemDetailCollection($records);
    }
    public function save_item_detail(Request $request)
    {
        $id = $request->input('id');
        $area = BoxesItemDetail::firstOrNew(['id' => $id]);
        $area->fill($request->all());
        $area->save();
        return [
            'success' => true,
            'message' => ($id) ? 'Área actualizada con éxito' : 'Área creada con éxito'
        ];
    }
    public function store(Request $request)
    {
        $id = $request->input('id');
        $area = BoxesDetail::firstOrNew(['id' => $id]);
        $area->fill($request->all());
        $area->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Área actualizada con éxito' : 'Área creada con éxito'
        ];
    }
    public function destroy($id)
    {
        //
    }
}
