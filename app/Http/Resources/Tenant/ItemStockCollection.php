<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Item;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Item\Models\ItemLot;

class ItemStockCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key) {

            $warehouses = $row->getDataWarehouses();
            $has_series =  ItemLot::where('item_id', $row->id)->first() ? true : false;
            $series = [
                'active' => 0,
                'desactive' => 0,
            ];
            if($has_series){
                $series = [
                    'active' => $row->item_lots->where('active', 1)->where('has_sale', 0)->count(),
                    'desactive' => $row->item_lots->where(function ($query) {
                        $query->where('active', 0)->orWhere('has_sale', 1);
                    })->count(),
                ];
            }

            return [
                'id' => $row->id,
                'description' => $row->description,
                'internal_id' => $row->internal_id,
                'stock' => $row->stock,
                'warehouses' => $warehouses,
                'has_series' =>  $has_series,
                'series' => $series,
            ];
        });
    }
}
