<?php

namespace App\Http\Controllers\Tenant;


use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\ItemColorSizeCollection;
use App\Http\Resources\Tenant\ItemColorSizeResource;
use App\Imports\ItemColorSizeImport;
use App\Models\Tenant\Company;
use App\Models\Tenant\Establishment;
use Modules\Inventory\Models\Inventory;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemColorSize;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\Warehouse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;
use Modules\Report\Exports\ExportColorZise;

class ItemColorSizeController extends Controller
{
    public function index()
    {
        return view('tenant.item_color_sizes.index');
    }
    public function import(Request $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '2048M');
        if ($request->hasFile('file')) {
            try {
                $import = new ItemColorSizeImport();
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

    public function lastRecord($item_id)
    {
        $last_record = ItemColorSize::where('item_id', $item_id)->count();
        return $last_record;
    }

    public function records(Request $request)
    {
        $records = $this->getRecords($request);

        return new ItemColorSizeCollection($records->paginate((int) config('tenant.items_per_page')));
    }

    public function getRecords(Request $request)
    {
        $records  = ItemColorSize::query();
        $item_id = $request->input('item_id');
        $warehouse_id = $request->input('warehouse_id');
        $status = $request->input('status');
        if ($status) {
            if ($status === 'Agotado') {
                $records->where('stock', 0);
            } elseif ($status === 'Disponible') {
                $records->where('stock', '>', 0);
            }
        }
        if ($item_id) {
            $records->where('item_id', $item_id);
        }
        if ($warehouse_id) {
            $records->where('warehouse_id', $warehouse_id);
        }
        $column = $request->input('column');
        $code = $request->input('code');
        $value = $request->input('value');
        if ($code) {
            $records->where('code', 'like', "%{$code}%");
        }
        if ($column && $value) {
            if ($column == 'description') {
                $records->whereHas('item', function ($query) use ($value) {
                    $query->where('description', 'like', "%{$value}%")
                        ->orWhere('internal_id', 'like', "%{$value}%");
                });
            } else {
                $records->where($column, 'like', "%{$value}%");
            }
        }
        return $records;
    }
    public function record($id)
    {
        $record = new ItemColorSizeResource(ItemColorSize::findOrFail($id));
        return $record;
    }
    public function columns()
    {
        return [
            'description' => 'Producto',
            'color' => 'Color',
            'size' => 'Talla',
            'code' => 'Código familia',
        ];
    }
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            
            $item_color_size = ItemColorSize::findOrFail($id);
            $item_id = $item_color_size->item_id;
            $item = Item::findOrFail($item_id);
            $item->stock = $item->stock - $item_color_size->stock;
            $warehouse_id = $item_color_size->warehouse_id;
            $warehouse_item = ItemWarehouse::where('item_id', $item_id)
                                         ->where('warehouse_id', $warehouse_id)
                                         ->first();
            $warehouse_item->stock = $warehouse_item->stock - $item_color_size->stock;
            $item->save();
            $warehouse_item->save();

            // Create JSON for color_size field
            $color_size_json = [
                'id' => $item_color_size->id,
                'item_id' => $item_color_size->item_id,
                'color' => $item_color_size->color,
                'size' => $item_color_size->size,
                'stock' => $item_color_size->stock,
                'warehouse_id' => $item_color_size->warehouse_id,
                'code' => $item_color_size->code,
            ];

            $item_color_size->delete();

            $inventory = new Inventory();
            $inventory->type = 1;
            $inventory->description = 'Eliminado manualmente una talla color del item ' . $item->description;
            $inventory->warehouse_id = $item_color_size->warehouse_id;
            $inventory->item_id = $item_color_size->item_id;
            $inventory->quantity = -$item_color_size->stock;
            $inventory->color_size = json_encode($color_size_json);
            $inventory->save();

            DB::commit();
            
            return [
                'success' => true,
                'message' => 'Talla eliminada con éxito'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function tables()
    {
        $warehouses = Warehouse::all();

        return compact('warehouses');
    }
    public function exportable()
    {

        $records = $this->getRecords(request())->get();
        $company = Company::first();
        $establishment = Establishment::first();

        return (new ExportColorZise)
            ->records($records)
            ->company($company)
            ->establishment($establishment)
            ->download('Talla_color_item' . '_' . Carbon::now()->format('Y-m-d') . '.xlsx');
    }
}
