<?php

namespace App\Imports;

use Exception;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemUnitType;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\Warehouse;
use Modules\Item\Models\Brand;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Modules\Restaurant\Models\Area;
use Modules\Restaurant\Models\Food;
use Modules\Item\Models\CategoryItem;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Modules\Inventory\Models\Inventory;
use Modules\Inventory\Traits\InventoryTrait;

class ItemsStockImport implements ToCollection
{
    use Importable;

    protected $data;
    protected $warehouse_id;

    public function setWarehouseId($warehouse_id)
    {
        $this->warehouse_id = $warehouse_id;
    }

    public function collection(Collection $rows)
    {
        $warehouse_id = $this->warehouse_id;

        Log::info('Warehouse ID en import asdasfsdfsdf: ' . $warehouse_id);

        if (is_null($warehouse_id)) {
            throw new Exception('El campo almacen no puede estar vacío.');
        }

        $total = count($rows);

        $registered = 0;
        unset($rows[0]);
        foreach ($rows as $row) {
            $internal_id = $row[0];
            $stock = $row[1];


            /* $warehouse_id = request('warehouse_id'); */

            if (is_null($warehouse_id)) {
                throw new Exception('el campo almacen no puede estar estar nulo vacio');
            }

            if ($internal_id != null) {

                $item = Item::where('internal_id', $internal_id)->first();

                if ($item != null) {
                    $item_warehouse = ItemWarehouse::where('item_id', $item->id)
                        ->where('warehouse_id', $warehouse_id)
                        ->first();
                    if ($item_warehouse) {
                        $result = $this->updateStock($item_warehouse->stock, $stock);
                        $inventory = new Inventory();
                        $inventory->type = $result['type'];
                        $inventory->description = 'Stock regularizado';
                        $inventory->item_id = $item->id;
                        $inventory->warehouse_id = $warehouse_id;
                        $inventory->detail = 'Ajuste por Rectificación';
                        $inventory->quantity = $result['quantity'];
                        $inventory->inventory_transaction_id = 28;
                        $inventory->real_stock = $stock;
                        $inventory->system_stock = $result['quantity'];
                        // Save the inventory without firing model events (to avoid any automatic
                        // listeners creating an inventory_kardex with missing data).
                        \Illuminate\Database\Eloquent\Model::withoutEvents(function () use ($inventory) {
                            $inventory->save();
                        });

                        // Create the inventory_kardex explicitly with the correct warehouse_id
                        // to ensure the non-null constraint is satisfied.
                        $inventory_kardex = $inventory->inventory_kardex()->create([
                            'date_of_issue' => date('Y-m-d'),
                            'item_id' => $item->id,
                            'warehouse_id' => $warehouse_id,
                            'quantity' => $result['quantity'],
                            'user_id' => isset(auth()->user()->id) ? auth()->user()->id : null,
                        ]);

                        $item->stock = 0;
                        $item->save();

                        // if ($result['type'] == 1) {
                        //     $item_warehouse->stock += $result['quantity'];
                        // } else {
                        //     $item_warehouse->stock -= $result['quantity'];
                        // }
                        // $item_warehouse->save();
                    }

                    $registered += 1;
                }
            }
        }
        $this->data = compact('total', 'registered');
    }
    function updateStock($old_quantity, $quantity)
    {
        $result = [];
        if ($old_quantity > $quantity) {
            $qty = $old_quantity - $quantity;
            $result = [
                'type' => 2,
                'quantity' => $qty
            ];
        } else {
            $qty = $quantity - $old_quantity;
            $result = [
                'type' => 1,
                'quantity' => $qty
            ];
        }
        return $result;
    }
    public function getData()
    {
        return $this->data;
    }
}
