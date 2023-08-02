<?php

namespace Modules\Inventory\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Inventory\Helpers\InventoryValuedKardex;

class ReportValuedStockCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        
        return $this->collection->transform(function($row, $key){
            
            $item = $row->item;

            return [

                        'id' => $item->id,
                        'description' => $item->description,
                        'stock' => $row->stock,
                        'unit_type' => $item->unit_type->description,
                        'unit_item' => $item->max_quantity_description,
                        'max_quantity_item' => $item->max_quantity,
                        'sale_unit_price' => $item->sale_unit_price,
                        'total' => $row->stock * $item->sale_unit_price,
                        'purchase_unit_price' => $item->purchase_unit_price,
                        'total_purchase' => $row->stock * $item->purchase_unit_price,
                        'gain' => $row->stock * $item->sale_unit_price - $row->stock * $item->purchase_unit_price,
                        'warehouse_id' => $row->warehouse_id,
                        'warehouse_description' => $row->warehouse->description,

            ];
        });
    }


}
