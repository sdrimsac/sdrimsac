<?php

namespace Modules\Dental\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DiseaseCollection extends ResourceCollection
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
                'id'                  => $row->id,
                'disease_type_id'     => $row->disease_type_id,
                'consultation_reason' => $row->consultation_reason,
                'signs_symptoms'      => $row->signs_symptoms,
                'personal_background' => $row->personal_background,
                'family_background'   => $row->family_background,
                'medicine'            => $row->medicine,
                'medicine_name'       => $row->medicine_name,
                'medicine_reason'     => $row->medicine_reason,
                'medicine_dose'       => $row->medicine_dose,
                'patient_id'          => $row->patient_id
            ];
        });
    }
}