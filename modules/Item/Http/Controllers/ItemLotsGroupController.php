<?php

namespace Modules\Item\Http\Controllers;

use App\Imports\LotGroupItemsImport;
use App\Models\Tenant\Company;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Warehouse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;
use Modules\Inventory\Models\Inventory;
use Modules\Item\Http\Resources\ItemLotsGroupCollection;
use Modules\Item\Models\Brand;
use Modules\Item\Models\ItemLotsGroup;
use Modules\Report\Exports\ItemLotGroupExport;

class ItemLotsGroupController extends Controller
{
    public function import(Request $request)
    {
        if ($request->hasFile('file')) {
            try {
                $import = new LotGroupItemsImport();
                $import->import($request->file('file'), null, Excel::XLSX);
                $data = $import->getData();
                return [
                    'success' => true,
                    'message' =>  __('app.actions.upload.success'),
                    'data' => $data
                ];
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' =>  $e->getMessage()
                ];
            }
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }
    public function index()
    {
        return view('item::item_lots_group.index');
    }

    public function to_due(Request $request)
    {
        $month = $request->month;
        if ($month == null) {
            $month = 2;
        }
        $records = ItemLotsGroup::where('date_of_due', '<=', Carbon::now()->addMonths($month))
            ->where('quantity', '>', 0);

        return new ItemLotsGroupCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function to_due_excel(Request $request)
    {
        $company = Company::first();
        $establishment = Establishment::first();
        $month = $request->month;
        if ($month == null) {
            $month = 2;
        }
        $records = ItemLotsGroup::where('date_of_due', '<=', Carbon::now()->addMonths($month))
            ->where('quantity', '>', 0)->get();

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
    public function excel(Request $request)
    {
        $date_filter = $request->date_filter;
        $date_filter_value = $request->date_filter_value;
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
        if ($date_filter_value) {
            $date = Carbon::parse($date_filter_value);
            if ($date_filter == 'week') {
                $records = $records->whereBetween('date_of_due', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')]);
            }
            if ($date_filter == 'month') {
                $records = $records->whereMonth('date_of_due', $date->month)
                    ->whereYear('date_of_due', $date->year);
            }
            if ($date_filter == 'year') {
                $records = $records->whereYear('date_of_due', $date->year);
            }
        }

        if ($d_start && $date_filter && $date_filter == 'between') {
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
            ->download('Reporte_Lotes_por_Producto_' . Carbon::now() . '.xlsx');
    }

    public function records(Request $request)
    {
        $lote = $request->lote;
        $date_filter = $request->date_filter;
        $date_filter_value = $request->date_filter_value;
        $item_id = $request->item_id;
        $warehouse_id = $request->warehouse_id;
        $d_start = $request->d_start;
        $d_end = $request->d_end;
        $date_of_due = $request->date_of_due;
        $records = ItemLotsGroup::where("id", "<>", null);
        if ($date_of_due) {
            $records = $records->where('date_of_due', '<=', $date_of_due);
        }
        if ($lote) {
            $records = $records->where('code', 'like', "%{$lote}%");
        }
        if ($item_id) {
            $records = $records->where('item_id', $item_id);
        }
        if ($warehouse_id) {
            $records = $records->where('warehouse_id', $warehouse_id);
        }
        if ($date_filter_value) {
            $date = Carbon::parse($date_filter_value);
            if ($date_filter == 'week') {
                $records = $records->whereBetween('date_of_due', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')]);
            }
            if ($date_filter == 'month') {
                $records = $records->whereMonth('date_of_due', $date->month)
                    ->whereYear('date_of_due', $date->year);
            }
            if ($date_filter == 'year') {
                $records = $records->whereYear('date_of_due', $date->year);
            }
        }

        if ($d_start && $date_filter && $date_filter == 'between') {
            if ($d_end) {
                $records = $records->whereBetween('date_of_due', [$d_start, $d_end]);
            } else {
                $records = $records->whereDate('date_of_due', $d_start);
            }
        }
        // que ordene por la ultima fecha de creacion hacia atraz lo lostes 
        $records = $records->orderBy('created_at', 'desc');

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

    /* public function eliminated($id)
    {
        try {
            DB::beginTransaction();

            $item_lots_group = ItemLotsGroup::findOrFail($id);
            
            if($item_lots_group->quantity > 0) {
                
                $item = $item_lots_group->item;
                $warehouse_id = $item_lots_group->warehouse_id;
                $quantity = $item_lots_group->quantity;

                $item_warehouse = DB::connection('tenant')->table('item_warehouse')
                    ->where('item_id', $item->id)
                    ->where('warehouse_id', $warehouse_id)
                    ->first();

                if($item_warehouse) {
                    DB::connection('tenant')->table('item_warehouse')
                        ->where('item_id', $item->id)
                        ->where('warehouse_id', $warehouse_id)
                        ->update(['stock' => $item_warehouse->stock - $quantity]);
                }

                $item->stock -= $quantity;
                $item->save();

                $item_lots_group->quantity = 0;
                $item_lots_group->status = '0';
                $item_lots_group->save();

                $inventory = new Inventory();
                $inventory->establishment_id = $item_lots_group->establishment_id;
                $inventory->warehouse_id = $item_lots_group->warehouse_id;
                $inventory->item_id = $item_lots_group->item_id;
                $inventory->item_lots_group_id = $item_lots_group->id;
                $inventory->quantity = $quantity;
                $inventory->date_of_due = $item_lots_group->date_of_due;
                $inventory->date_of_inventory = Carbon::now()->format('Y-m-d H:i:s');
                $inventory->type = 'eliminated';
                $inventory->user_id = auth()->user()->id;
                $inventory->save();
            }

            DB::commit();

            return [
                'success' => true,
                'message' => 'Lote dado de baja con éxito'
            ];

        } catch (Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => "Error al dar de baja el lote: {$e->getMessage()}"
            ];
        }
    } */

    public function eliminated($id)
    {
        try {
            DB::beginTransaction();

            $item_lots_group = ItemLotsGroup::findOrFail($id);

            if ($item_lots_group->quantity > 0) {
                $item = $item_lots_group->item;
                $warehouse_id = $item_lots_group->warehouse_id;
                $lot_quantity = $item_lots_group->quantity;

                // Update item stock - only reduce by this lot's quantity

                $item->stock -= $lot_quantity;
                $item->save();

                // Update lots group
                $item_lots_group->quantity = 0;
                $item_lots_group->status = '0';
                $item_lots_group->save();

                $inventory = new Inventory();
                $inventory->type = 1;
                $inventory->description = 'Lote dado de baja ' . $item->description;
                $inventory->warehouse_id = $item_lots_group->warehouse_id;
                $inventory->item_id = $item_lots_group->item_id;
                $inventory->quantity = -$lot_quantity;
                $inventory->lot_code = $item_lots_group->code;
                $inventory->save();
            }

            DB::commit();

            return [
                'success' => true,
                'message' => 'Lote dado de baja con éxito'
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => "Error al dar de baja el lote: {$e->getMessage()}"
            ];
        }
    }
}
