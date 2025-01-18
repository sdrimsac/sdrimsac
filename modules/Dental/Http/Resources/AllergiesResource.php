<?php

namespace Modules\Dental\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AllergiesResource extends JsonResource
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
            'id'                 => $this->id,
            'observation'        => $this->observation,
            'allergies_types_id' => $this->allergies_types_id,
            'patient_id'         => $this->patient_id
        
        ];
    }
}