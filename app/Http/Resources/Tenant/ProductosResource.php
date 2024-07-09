<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductosResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            /* 'internal_id' => $this->internal_id, */
            'item_id' => $this->item_id,
            'item_description' => $this->item->description,
            'warehouse_id' => $this->warehouse_id,
            'warehouse_description' => $this->warehouse->description,
            'quantity' => $this->stock,
            'type' => $this->type,
            'warehouse_new_id' => null,
            'quantity_move' => 0
        ];
    }
}