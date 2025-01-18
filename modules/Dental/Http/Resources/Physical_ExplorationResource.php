<?php

namespace Modules\Dental\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Physical_ExplorationResource extends JsonResource
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
            'id'                           => $this->id,
            'blood_pressure'               => $this->blood_pressure,
            'pulse'                        => $this->pulse,
            'temperature'                  => $this->temperature,
            'heart_rate'                   => $this->heart_rate,
            'respiratory_rate'             => $this->respiratory_rate,
            'weight'                       => $this->weight,
            'height'                       => $this->height,
            'imc'                          => $this->imc,
            'general_clinical_examination' => $this->general_clinical_examination,
            'complementary_examination'    => $this->complementary_examination,
            'odontostomatological'         => $this->odontostomatological,
            'patient_id'                   => $this->patient_id
        ];
    }
}