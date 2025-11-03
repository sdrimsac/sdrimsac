<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductosCollection extends ResourceCollection
{

    public function toArray($request)
    {
        $item_id = $request->input('description');
        $warehouse_id = $request->input('warehouse_id');
        $category_id = $request->input('category_id');
        $inventoryTransactionType = $request->input('inventory_transaction_type');

        $filtered = $this->collection->filter(function ($inventory) use ($item_id, $warehouse_id, $category_id, $inventoryTransactionType) {
            if ($item_id && $inventory->item_id != $item_id) {
                return false;
            }

            if ($warehouse_id && $inventory->warehouse_id != $warehouse_id) {
                return false;
            }

            if ($category_id && (!isset($inventory->item) || $inventory->item->category_id != $category_id)) {
                return false;
            }

            if ($inventoryTransactionType && (!isset($inventory->inventoryTransaction) || $inventory->inventoryTransaction->type != $inventoryTransactionType)) {
                return false;
            }
            return true;
        });

        return $filtered->map(function ($inventory)  {
            $lots = json_decode($inventory->lots, true);
            $color_size =json_decode($inventory->color_size, true);
            return [
                'color_size' => $color_size,
                'id' => $inventory->id,
                'inventory_transaction_id' => optional($inventory->inventoryTransaction)->id,
                'type' => (optional($inventory->inventoryTransaction)->type !== null) ? (optional($inventory->inventoryTransaction)->type == 'input' ? 'input' : 'output') : null,
                'quantity' => $inventory->quantity,
                'item_id' => $inventory->item_id,
                'item_description' => optional($inventory->item)->description,
                'item_internal_id' => optional($inventory->item)->internal_id,
                'warehouse_id' => $inventory->warehouse_id,
                'category_name' => optional(optional($inventory->item)->category)->name,
                'warehouse_description' => optional($inventory->warehouse)->description,
                'created_at' => $inventory->created_at->format('Y-m-d H:i:s'),
                'lot_code' => $inventory->lot_code,
                'lots' => $lots,
            ];
        });
    }
}
