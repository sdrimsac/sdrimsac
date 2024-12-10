<?php

namespace Modules\Billar\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CasinoResource extends JsonResource
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
            'table_id' => $this->table_id,
            'customer_id' => $this->customer_id,
            'reference' => $this->reference,
            'date_start' => $this->date_start,
            'time_start' => $this->time_start,
            'minutes' => $this->minutes,
            'date_end' => $this->date_end,
            'time_end' => $this->time_end,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}