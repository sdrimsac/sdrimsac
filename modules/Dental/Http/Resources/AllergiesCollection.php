<?php

namespace Modules\Dental\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AllergiesCollection extends ResourceCollection
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
                'observation'        => $row->observation,
                'allergies_types_id' => $row->allergies_types_id,
                'patient_id'         => $row->patient_id
            ];
        });
    }
}