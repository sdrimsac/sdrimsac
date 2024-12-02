<?php

namespace App\Http\Controllers\Tenant;


use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\WarrantyCollection;
use App\Http\Resources\Tenant\WarrantyResource;
use App\Imports\ItemColorSizeImport;
use App\Models\Tenant\Company;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemColorSize;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\ItemWarranty;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Modules\Report\Exports\ExportWarranty;

class WarrantyController extends Controller
{
    public function index()
    {
        return view('tenant.warranty.index');
    }
    public function ExportarExcel(Request $request)
    {
        ini_set('memory_limit', '2048M');
        $records = $this->getRecords($request)->get();
        if ($records->isEmpty()) {
            return response()->json(['message' => 'No hay datos para exportar.'], 204);
        }
        $company = Company::first();
        return (new ExportWarranty)
            ->records($records)
            ->company($company)
            ->download('Productos_garantia' . '_' . Carbon::now()->format('Y-m-d') . '.xlsx');

        
    }

    /* public function records(Request $request)
    {
        $records  = ItemWarranty::query();
        $item_id = $request->input('item_id');
        if ($item_id) {
            $records->where('item_id', $item_id);
        }
        $column = $request->input('column');
        $value = $request->input('value');
        
        if ($column && $value) {
            if ($column == 'description') {
                $records->whereHas('item', function ($query) use ($value) {
                    $query->where('description', 'like', "%{$value}%")
                        ->orWhere('internal_id', 'like', "%{$value}%");
                });
            } 
            else {
                $records->where($column, 'like', "%{$value}%");
            }
        }
        return new WarrantyCollection($records->paginate(config('tenant.items_per_page')));
    } */
    public function records(Request $request)
    {
        $records = $this->getRecords($request);
        
        return new WarrantyCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function getRecords(Request $request)
    {
        $records = ItemWarranty::query()
            ->with([
                'documentItem.document',
                'saleNoteItem.sale_note',
            ]);

        $column = $request->input('column');
        $value = $request->input('value');
        if ($column && $value) {
            if ($column == 'warranty_start_date') {
                $records->whereHas('itemWarranty', function ($query) use ($value) {
                    $query->where('warranty_start_date', 'like', "%{$value}%");
                        
                });
            } else {
                $records->where($column, 'like', "%{$value}%");
            }
        }
        return $records;
    }

    public function record($id)
    {
        $record = new WarrantyResource(ItemWarranty::findOrFail($id));
        return $record;
    }
    public function columns()
    {
        return [
            'warranty_start_date' => 'garantía_inicio',
        ];
    }
    public function delete($id)
    {
        $item_color_size = ItemWarranty::findOrFail($id);
        $item_id = $item_color_size->item_id;
        $item = Item::findOrFail($item_id);
        $item->stock = $item->stock - $item_color_size->stock;
        $warehouse_id = $item_color_size->warehouse_id;
        $warehouse_item = ItemWarehouse::where('item_id', $item_id)->where('warehouse_id', $warehouse_id)->first();
        $warehouse_item->stock = $warehouse_item->stock - $item_color_size->stock;
        $item->save();
        $warehouse_item->save();
        $item_color_size->delete();
        return [
            'success' => true,
            'message' => 'Talla eliminada con éxito'
        ];
    }
}
