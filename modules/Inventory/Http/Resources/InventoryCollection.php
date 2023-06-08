<?php

namespace Modules\Inventory\Http\Resources;

use App\Models\Tenant\Item;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Item\Models\ItemLot;

class InventoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->collection->transform(function ($row, $key) {
            $lots = ItemLot::where('item_id', $row->item_id)->where('has_sale', false)->get()
            ->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'series' => $row->series,
                    'date' => $row->date,
                    'item_id' => $row->item_id,
                    'warehouse_id' => $row->warehouse_id,
                    'has_sale' => (bool)$row->has_sale,
                    'lot_code' => ($row->item_loteable_type) ? (isset($row->item_loteable->lot_code) ? $row->item_loteable->lot_code : null) : null
                ];
            })
            ;
            return [
                'id' => $row->id,
                'item_internal_id' => $row->item->internal_id,
                'item_description' => $row->item->description,
                'item_fulldescription' => ($row->item->internal_id) ? "{$row->item->internal_id} - {$row->item->description}" : $row->item->description,
                'warehouse_description' => $row->warehouse->description,
                'sale_unit_price' => $row->item->sale_unit_price,
                'purchase_unit_price' => $row->item->purchase_unit_price,
                "real_stock" => $row->real_stock,
                "system_stock" => $row->system_stock,
                'series_enabled' => (bool) $row->item->series_enabled,
                'series' => $lots,
                'stock' => $row->stock,
                'created_at' => $row->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $row->updated_at->format('Y-m-d H:i:s'),
            ];
        });
    }
}
