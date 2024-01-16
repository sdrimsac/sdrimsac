<?php

namespace Modules\Item\Http\Controllers;

use App\Http\Resources\Tenant\ItemCollection;
use App\Models\Tenant\Company;
use App\Models\Tenant\InventoryKardex;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\Warehouse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Item\Http\Resources\ItemManufacturedCollection;
use Modules\Item\Models\ItemManufactured;
use Modules\Item\Models\ItemManufacturedItems;

class ItemManufacturedController extends Controller
{

    public function index()
    {
        return view('item::manufactured.index');
    }

    public function searchItems(Request $request)
    {
        $warehouse_id = $request->input('warehouse_id');
        $input = $request->input('input');
        $items = Item::where('unit_type_id', '!=', 'ZZ')
            ->whereHas('warehouses', function ($query) use ($warehouse_id) {
                $query->where('warehouse_id', $warehouse_id);
            })
            ->where(function ($query) use ($input) {
                $query->where('description', 'like', "%{$input}%")
                    ->orWhere('internal_id', 'like', "%{$input}%");
            })
            ->take(10)->get();
        return compact('items');
    }
    public function getLastItems($id)
    {
        $manufactured_item = ItemManufactured::where('item_id', $id)->first();
        $items = [];
        if ($manufactured_item) {
            $items = $manufactured_item->items;
        }
        return [
            'success' => true,
            'data' => $items
        ];
    }
    public function columns()
    {
        return [
            'description' => 'Descripción',
        ];
    }

    public function tables()
    {
        $warehouses = Warehouse::all();

        return compact('warehouses');
    }
    public function sendItems(Request $request)
    {
        try {
            DB::beginTransaction();
            $items = $request->input('items');
            $warehouse_id = $request->input('warehouse_id');
            $manufactured_id = $request->input('manufactured_id');
            $quantity_general = 0;
            $item_general = ItemWarehouse::where('item_id', $manufactured_id)->where('warehouse_id', $warehouse_id)->first();
            if (!$item_general) {
                $item_general = new ItemWarehouse;
                $item_general->item_id = $manufactured_id;
                $item_general->warehouse_id = $warehouse_id;
                $item_general->stock = 0;
                $item_general->save();
            }
            $item_manufactured = new ItemManufactured;
            $item_manufactured->item_id = $manufactured_id;
            $item_manufactured->date_of_issue = date('Y-m-d');
            $item_manufactured->save();
            foreach ($items as $item) {
                $item_warehouse = ItemWarehouse::where('item_id', $item['id'])->where('warehouse_id', $warehouse_id)->first();
                if ($item_warehouse) {
                    $init_quantity = $item['quantity'];
                    $quantity = 0;
                    $max_quantity = $item['max_quantity'];
                    if ($max_quantity) {
                        $quantity = $init_quantity * $max_quantity;
                    } else {
                        $quantity = $init_quantity;
                    }
                    $item_warehouse->stock = $item_warehouse->stock - $quantity;
                    $quantity_general = $quantity_general + $quantity;
                    $item_warehouse->save();
                    ItemManufacturedItems::create([
                        'item_id' => $item['id'],
                        'quantity' => $quantity,
                        'manufactured_record_id' => $item_manufactured->id
                    ]);
                    InventoryKardex::create([
                        'date_of_issue' => date('Y-m-d'),
                        'item_id' => $item['id'],
                        'warehouse_id' => $warehouse_id,
                        'quantity' => $quantity * -1,
                        'inventory_kardexable_id' => $item_manufactured->id,
                        'inventory_kardexable_type' => 'Modules\Item\Models\ItemManufactured'
                    ]);
                }
            }
            $item_general->stock = $item_general->stock + $quantity_general;
            $item_general->save();
            InventoryKardex::create([
                'date_of_issue' => date('Y-m-d'),
                'item_id' => $manufactured_id,
                'warehouse_id' => $warehouse_id,
                'quantity' => $quantity_general,
                'inventory_kardexable_id' => $item_manufactured->id,
                'inventory_kardexable_type' => 'Modules\Item\Models\ItemManufactured'
            ]);
            DB::commit();
            return [
                'success' => true,
                'message' => 'Transformación realizada con éxito'
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    public function records(Request $request)
    {
        $column = $request->input('column');
        $value = $request->input('value');
        $records = Item::where('is_manufactured', 1);

        if ($value) {
            if ($column == 'description') {
                $records = $records->where($column, 'like', "%{$value}%")
                    ->orWhere('internal_id', 'like', "%{$value}%");;
            } else {
                $records = $records->where($column, 'like', "%{$value}%");
            }
        }

        return new ItemCollection($records->paginate(config('tenant.items_per_page')));
    }
    // public function export(Request $request)
    // {
    //     $company = Company::first();
    //     $records = ItemManufactured::where($request->column, 'like', "%{$request->value}%")
    //         ->get();

    //     return (new BrandExport)
    //         ->records($records)
    //         ->company($company)
    //         ->download('Reporte_de_marcas_' . Carbon::now() . '.xlsx');
    // }


    public function record($id)
    {
        $record = ItemManufactured::findOrFail($id);

        return $record;
    }

    public function store(Request $request)
    {
        $id = $request->input('id');
        $brand = ItemManufactured::firstOrNew(['id' => $id]);
        $brand->fill($request->all());
        $brand->save();


        return [
            'success' => true,
            'message' => ($id) ? 'Marca editada con éxito' : 'Marca registrada con éxito',
            'data' => $brand
        ];
    }

    public function destroy($id)
    {
        try {

            $brand = ItemManufactured::findOrFail($id);
            $brand->delete();

            return [
                'success' => true,
                'message' => 'Marca eliminada con éxito'
            ];
        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false, 'message' => "La Marca esta siendo usada por otros registros, no puede eliminar"] : ['success' => false, 'message' => "Error inesperado, no se pudo eliminar la Marca"];
        }
    }
}
