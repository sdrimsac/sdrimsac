<?php

namespace Modules\Dental\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicResource extends JsonResource
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
            'id' => $this->id,
                'specialty_id'=> $this->specialty_id,
                'name'=> $this->name,
                'number'=> $this->number,
                'country_id'=> $this->country_id,
                'name'=> $this->name,
                'department_id'=> $this->department_id,
                'province_id'=> $this->province_id,
                'district_id'=> $this->district_id,
                'address'=> $this->address,
                'email'=> $this->email,
                'telephone'=> $this->telephone,     
                'sexo' => $this->sexo,
                /* 'specialty' => $row->specialty->description, */ 
                'created_at' => \Carbon\Carbon::parse($this->created_at)->format('d-m-Y H:i:s'),
                'updated_at' => \Carbon\Carbon::parse($this->updated_at)->format('d-m-Y H:i:s'),
        ];
    }
}