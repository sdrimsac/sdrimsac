<?php

namespace Modules\Item\Http\Controllers;

use App\Models\Tenant\Warehouse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Item\Http\Resources\ItemLotsGroupCollection;
use Modules\Item\Models\Brand;
use Modules\Item\Models\ItemLotsGroup;

class ItemLotsGroupController extends Controller
{

    public function index()
    {
        return view('item::item_lots_group.index');
    }


    public function columns()
    {
        return [
            'name' => 'Nombre',
        ];
    }

    public function records(Request $request)
    {
        $lote = $request->lote;
        $item_id = $request->item_id;
        $warehouse_id = $request->warehouse_id;
        $d_start = $request->d_start;
        $d_end = $request->d_end;
        $records = ItemLotsGroup::where("id", "<>", null);
        if ($lote) {
            $records = $records->where('code', 'like', "%{$lote}%");
        }
        if ($item_id) {
            $records = $records->where('item_id', $item_id);
        }
        if ($warehouse_id) {
            $records = $records->where('warehouse_id', $warehouse_id);
        }
        if ($d_start) {
            if ($d_end) {
                $records = $records->whereBetween('date_of_due', [$d_start, $d_end]);
            } else {
                $records = $records->whereDate('date_of_due', $d_start);
            }
        }


        return new ItemLotsGroupCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function tables()
    {

        $warehouses = Warehouse::all();
        return compact('warehouses');
    }
    public function record($id)
    {
        $record = ItemLotsGroup::findOrFail($id);

        return $record;
    }

    // public function store(BrandRequest $request)
    // {
    //     $id = $request->input('id');
    //     $brand = Brand::firstOrNew(['id' => $id]);
    //     $brand->fill($request->all());
    //     $brand->save();


    //     return [
    //         'success' => true,
    //         'message' => ($id)?'Marca editada con éxito':'Marca registrada con éxito',
    //         'data' => $brand
    //     ];

    // }

    public function destroy($id)
    {
        try {

            $item_lots_group = ItemLotsGroup::findOrFail($id);
            $item_lots_group->delete();

            return [
                'success' => true,
                'message' => 'Lote eliminado con éxito'
            ];
        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false, 'message' => "La Marca esta siendo usada por otros registros, no puede eliminar"] : ['success' => false, 'message' => "Error inesperado, no se pudo eliminar la Marca"];
        }
    }
}
