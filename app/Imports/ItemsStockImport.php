<?php

namespace App\Imports;

use Exception;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemUnitType;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\Warehouse;
use Modules\Item\Models\Brand;
use Illuminate\Support\Collection;
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

    public function collection(Collection $rows)
    {
        //try {
        $total = count($rows);

        $registered = 0;
        unset($rows[0]);
        foreach ($rows as $row) {
            $internal_id = $row[0];
            $stock = $row[1];


            $warehouse_id = request('warehouse_id');

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
                        $inventory->save();

                        $item->stock = 0;
                        $item->save();

                        // $inventory_kardex =  $inventory->inventory_kardex()->create([
                        //     'date_of_issue' => date('Y-m-d'),
                        //     'item_id' => $item->id,
                        //     'warehouse_id' => $warehouse_id,
                        //     'quantity' => $result['quantity'],
                        // ]);

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
