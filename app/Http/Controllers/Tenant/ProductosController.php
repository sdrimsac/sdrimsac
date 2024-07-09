<?php

namespace App\Http\Controllers\Tenant;

use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Exports\ProductosExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\ProductosCollection;
use App\Models\Tenant\Company;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Inventory;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Inventory\Models\Category;

class ProductosController extends Controller
{
    public function index()
    {
        return view('tenant.productos.index');
    }

    public function columns()
    {
        return [
            'item_id' => 'Producto'
        ];
    }

    public function tables()
    {
        return response()->json([
            'items' => Item::whereNotNull('description')->get(),
            'warehouses' => Warehouse::all(),
            'categories' => Category::all(),
            'inventories' => Inventory::whereNotNull('created_at')->get(),
        ]);
    }

    public function get_records(Request $request)
    {
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $qty_type = $request->qty_type;
        /* $item_description = $request->item_description; */
        $records = Inventory::whereNotNull('inventory_transaction_id')
            ->whereHas('inventoryTransaction', function ($query) use ($qty_type) {
                if ($qty_type) {
                    $query->where('type', $qty_type);
                }
            })

            ->select(['id', 'inventory_transaction_id', 'quantity', 'item_id', 'warehouse_id', 'created_at', 'lot_code', 'lots','color_size'])
            ->with([
                'inventoryTransaction:id,type',
                'item:id,description,internal_id,category_id',
                'item.category:id,name',
                'warehouse:id,description'
            ]);

        $records->whereHas('inventoryTransaction', function ($query) {
            $query->whereIn('type', ['input', 'output']);
        });

        $records = $records->orderBy('updated_at', 'desc');

        if ($date_start || $date_end) {
            if ($date_start && $date_end) {
                $records = $records->whereBetween('created_at', [$date_start, $date_end]);
            } else {
                $records = $records->where('created_at', $date_start ?? $date_end);
            }
        }
        return $records;
    }

    public function records(Request $request)
    {

        $records = $this->get_records($request);

        return new ProductosCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function store(Request $request)
    {
        $result = DB::connection('tenant')->transaction(function () use ($request) {
            $item_id = $request->input('item_id');
            $warehouse_id = $request->input('warehouse_id');
            $quantity = $request->input('quantity');

            $item_warehouse = ItemWarehouse::firstOrNew([
                'item_id' => $item_id,
                'warehouse_id' => $warehouse_id
            ]);
            if ($item_warehouse->id) {
                return [
                    'success' => false,
                    'message' => 'El producto ya se encuentra registrado en el almacén indicado.'
                ];
            }

            // $item_warehouse->stock = $quantity;
            // $item_warehouse->save();

            $inventory = new Inventory();
            $inventory->type = 1;
            $inventory->description = 'Stock inicial';
            $inventory->item_id = $item_id;
            $inventory->warehouse_id = $warehouse_id;
            $inventory->quantity = $quantity;
            $inventory->save();

            return  [
                'success' => true,
                'message' => 'Producto registrado en almacén'
            ];
        });

        return $result;
    }

    public function move(Request $request)
    {
        $result = DB::connection('tenant')->transaction(function () use ($request) {
            $id = $request->input('id');
            $item_id = $request->input('item_id');
            $warehouse_id = $request->input('warehouse_id');
            $warehouse_new_id = $request->input('warehouse_new_id');
            $quantity = $request->input('quantity');
            $quantity_move = $request->input('quantity_move');

            if ($warehouse_id === $warehouse_new_id) {
                return  [
                    'success' => false,
                    'message' => 'El almacén destino no puede ser igual al de origen'
                ];
            }
            if ($quantity < $quantity_move) {
                return  [
                    'success' => false,
                    'message' => 'La cantidad a trasladar no puede ser mayor al que se tiene en el almacén.'
                ];
            }

            //Transaction
            // $item_warehouse_new = ItemWarehouse::firstOrNew(['item_id' => $item_id,
            //                                                  'warehouse_id' => $warehouse_new_id]);

            // $stock_new = ($item_warehouse_new)?$item_warehouse_new->stock + $quantity_move:$quantity_move;
            // $item_warehouse_new->stock = $stock_new;
            // $item_warehouse_new->save();

            // $item_warehouse = ItemWarehouse::find($id);
            // $item_warehouse->stock = (float) $quantity - (float)$quantity_move;
            // $item_warehouse->save();

            $inventory = new Inventory();
            $inventory->type = 2;
            $inventory->description = 'Traslado';
            $inventory->item_id = $item_id;
            $inventory->warehouse_id = $warehouse_id;
            $inventory->warehouse_destination_id = $warehouse_new_id;
            $inventory->quantity = $quantity_move;
            $inventory->save();

            return  [
                'success' => true,
                'message' => 'Producto trasladado con éxito'
            ];
        });

        return $result;
    }

    public function remove(Request $request)
    {
        $result = DB::connection('tenant')->transaction(function () use ($request) {
            $item_id = $request->input('item_id');
            $warehouse_id = $request->input('warehouse_id');
            $quantity = $request->input('quantity');
            $quantity_remove = $request->input('quantity_remove');

            //Transaction
            $item_warehouse = ItemWarehouse::where('item_id', $item_id)
                ->where('warehouse_id', $warehouse_id)
                ->first();
            if (!$item_warehouse) {
                return [
                    'success' => false,
                    'message' => 'El producto no se encuentra en el almacén indicado'
                ];
            }

            if ($quantity < $quantity_remove) {
                return  [
                    'success' => false,
                    'message' => 'La cantidad a retirar no puede ser mayor al que se tiene en el almacén.'
                ];
            }

            // $item_warehouse->stock = $quantity - $quantity_remove;
            // $item_warehouse->save();

            $inventory = new Inventory();
            $inventory->type = 3;
            $inventory->description = 'Retirar';
            $inventory->item_id = $item_id;
            $inventory->warehouse_id = $warehouse_id;
            $inventory->quantity = $quantity_remove;
            $inventory->save();

            return  [
                'success' => true,
                'message' => 'Producto trasladado con éxito'
            ];
        });

        return $result;
    }

    public function excel(Request $request)
    {
        $company = Company::first();
        $establishment = Establishment::first();
        $category_id = $request->category_id;
        $reports = $this->get_records($request)->get();

        return Excel::download((new ProductosExport())
                ->records($reports)
                ->establishment($establishment)
                ->company($company),
            'ReporteTransac_' . Carbon::now()->format('Ymd_His') . '.xlsx'
        );
    }
}
