<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
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
            'person_id' => $this->person_id,
            'name' => $this->name,
            'entrada' => $this->entrada,
            'salida' => $this->salida,
            'tolerancia_min' => $this->tolerancia_min,
        ];
    }
}
