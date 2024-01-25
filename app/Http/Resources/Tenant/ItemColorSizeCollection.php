<?php

namespace App\Http\Resources\Tenant;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ItemColorSizeCollection extends ResourceCollection
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
            return [
                'id' => $row->id,
                'color' => $row->color,
                'size' => $row->size,
                'stock' => $row->stock,
                'warehouse_id' => $row->warehouse_id,
                'item_description' => $row->item->description,
                'item_internal_id' => $row->item->internal_id,
            ];
        });
    }
}