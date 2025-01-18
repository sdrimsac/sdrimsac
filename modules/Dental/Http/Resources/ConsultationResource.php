<?php

namespace Modules\Dental\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultationResource extends JsonResource
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
            'id'                => $this->id,
            'orthodontics'      => $this->orthodontics,
            'medicine'          => $this->medicine,
            'allergy'           => $this->allergy,
            'hospital_surgery'  => $this->hospital_surgery,
            'disorder'          => $this->disorder,
            'brush_teeth'       => $this->brush_teeth,
            'high_pressure'     => $this->high_pressure,
            'disease_type_id'   => $this->disease_type_id,
            'patient_id'        => $this->patient_id
           
        ];
    }
}