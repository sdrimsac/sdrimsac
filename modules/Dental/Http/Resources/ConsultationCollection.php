<?php

namespace Modules\Dental\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ConsultationCollection extends ResourceCollection
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
                'id'               => $row->id,
                'orthodontics'     => $row->orthodontics,
                'medicine'         => $row->medicine,
                'allergy'          => $row->allergy,
                'hospital_surgery' => $row->hospital_surgery,
                'disorder'         => $row->disorder,
                'brush_teeth'      => $row->brush_teeth,
                'high_pressure'    => $row->high_pressure,
                'disease_type_id'  => $row->disease_type_id,
                'patient_id'       => $row->patient_id
               
            ];
        });
    }
}