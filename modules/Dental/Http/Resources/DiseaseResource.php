<?php

namespace Modules\Dental\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiseaseResource extends JsonResource
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
            'id'                   => $this->id,
            'disease_type_id'      => $this->disease_type_id,
            'consultation_reason'  => $this->consultation_reason,
            'signs_symptoms'       => $this->signs_symptoms,
            'personal_background'  => $this->personal_background,
            'family_background'    => $this->family_background,
            'medicine'             => $this->medicine,
            'medicine_name'        => $this->medicine_name,
            'medicine_reason'      => $this->medicine_reason,
            'medicine_dose'        => $this->medicine_dose,
            'patient_id'           => $this->patient_id
        ];
    }
}