<?php

namespace Modules\Workshop\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HistorialItemResource extends JsonResource
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
            'item_id' => $this->item_id,
            'cantidad' => $this->cantidad,
            'price' => $this->price,
            'historial_id' => $this->historial_id,
        ];
    }
}