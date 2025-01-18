<?php

namespace Modules\Dental\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EvolutionResource extends JsonResource
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
            'id'          => $this->id,
            'patient_id'  => $this->patient_id,
            'medic_id'    => $this->medic_id,
            'date'        => $this->date,
            'observation' => $this->observation
        ];
    }
}