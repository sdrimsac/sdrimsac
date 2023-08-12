<?php

namespace Modules\Item\Http\Controllers;

use App\Models\Tenant\Company;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Warehouse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Item\Http\Resources\ItemLotsGroupCollection;
use Modules\Item\Models\Brand;
use Modules\Item\Models\ItemLotsGroup;
use Modules\Report\Exports\ItemLotGroupExport;

class ItemLotsGroupController extends Controller
{

    public function index()
    {
        return view('item::item_lots_group.index');
    }

    public function to_due(Request $request){
        $month = $request->month;
        if($month == null){
            $month = 2;
        }
        $records = ItemLotsGroup::where('date_of_due', '<=', Carbon::now()->addMonths($month))
        ->where('quantity', '>', 0)
        ;

        return new ItemLotsGroupCollection($records->paginate(config('tenant.items_per_page')));

    }
    public function to_due_excel(Request $request){
        $company = Company::first();
        $establishment = Establishment::first();
        $month = $request->month;
        if($month == null){
            $month = 2;
        }
        $records = ItemLotsGroup::where('date_of_due', '<=', Carbon::now()->addMonths($month))
        ->where('quantity', '>', 0)->get()
        ;

        return (new ItemLotGroupExport)
                ->records($records)
                ->company($company)
                ->establishment($establishment)
                ->download('Reporte_Lotes_por_vencer.xlsx');


    }

    public function columns()
    {
        return [
            'name' => 'Nombre',
        ];
    }
    public function excel(Request $request){
        $company = Company::first();
        $establishment = Establishment::first();

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

        

        return (new ItemLotGroupExport)
                ->records($records->get())
                ->company($company)
                ->establishment($establishment)
                ->download('Reporte_Ventas_por_Producto_'.Carbon::now().'.xlsx');
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
