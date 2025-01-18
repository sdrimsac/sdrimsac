<?php

namespace Modules\Dental\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EvolutionCollection extends ResourceCollection
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
                'patient_id'       => $row->patient_id,
                'medic_id'         => $row->medic_id,
                'date'             => $row->date,
                'observation'      => $row->observation,
               
            ];
        });
    }
}