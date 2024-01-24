<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemColorSizeResource extends JsonResource
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
            'color' => $this->color,
            'size' => $this->size,
            'stock' => $this->stock,
            'warehouse_id' => $this->warehouse_id,
        ];
    }
}
