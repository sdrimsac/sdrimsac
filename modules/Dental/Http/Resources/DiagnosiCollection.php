<?php

namespace Modules\Dental\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DiagnosiCollection extends ResourceCollection
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
                'id'                 => $row->id,
                'diagnosis_types_id' => $row->diagnosis_types_id,
                'date'               => $row->date,
                'patient_id'         => $row->patient_id
               
            ];
        });
    }
}