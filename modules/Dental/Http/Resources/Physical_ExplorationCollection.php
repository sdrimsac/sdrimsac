<?php

namespace Modules\Dental\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Physical_ExplorationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->collection->transform(function ($row, $key) {

            return [
                'id'                           => $row->id,
                'blood_pressure'               => $row->blood_pressure,
                'pulse'                        => $row->pulse,
                'temperature'                  => $row->temperature,
                'heart_rate'                   => $row->heart_rate,
                'respiratory_rate'             => $row->respiratory_rate,
                'weight'                       => $row->weight,
                'height'                       => $row->height,
                'imc'                          => $row->imc,
                'general_clinical_examination' => $row->general_clinical_examination,
                'complementary_examination'    => $row->complementary_examination,
                'odontostomatological'         => $row->odontostomatological,
                'patient_id'                   => $row->patient_id
            ];
        });
    }
}