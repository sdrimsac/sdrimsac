<?php

namespace Modules\Dental\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class QuotyCollection extends ResourceCollection
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

                'patient_id'            => $row->patient_id,
                'medic_id'              => $row->medic_id,
                'date'                  => $row->date,
                'time'                  => $row->time,
                'price'                 => $row->price,
                'state'                 => $row->state,
                'reason_consultation'   => $row->reason_consultation,
                'observation'           => $row->observation,
                'medic' => $row->doctor,
                'patient' => $row->patient
            ];
        });
    }
}