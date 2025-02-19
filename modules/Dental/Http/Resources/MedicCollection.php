<?php

namespace Modules\Dental\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MedicCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key) {
            return [
                'id' => $row->id,
                'specialty_id'=> $row->specialty_id,
                'name'=> $row->name,
                'number'=> $row->number,
                'country_id'=> $row->country_id,
                'name'=> $row->name,
                'department_id'=> $row->department_id,
                'province_id'=> $row->province_id,
                'district_id'=> $row->district_id,
                'address'=> $row->address,
                'email'=> $row->email,
                'telephone'=> $row->telephone,     
                'sexo' => $row->sexo,
                'specialty' => $row->specialty ? $row->specialty->description : null,
                /* 'specialty' => $row->specialty->description, */
                'created_at' => \Carbon\Carbon::parse($row->created_at)->format('d-m-Y H:i:s'),
                'updated_at' => \Carbon\Carbon::parse($row->updated_at)->format('d-m-Y H:i:s'),
            ];
        });
    }
}