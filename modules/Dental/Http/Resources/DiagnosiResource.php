<?php

namespace Modules\Dental\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiagnosiResource extends JsonResource
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
            'diagnosis_types_id' => $this->diagnosis_types_id,
            'date'               => $this->date,
            'patient_id'         => $this->patient_id
           
        ];
    }
}