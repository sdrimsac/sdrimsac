<?php

namespace Modules\Dental\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
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
            'type'=> $this->type,
            'identity_document_type_id'=> $this->identity_document_type_id,
            'number'=> $this->number,
            'name'=> $this->name,
            'trade_name'=> $this->trade_name,
            'country_id'=> $this->country_id,
            'department_id'=> $this->department_id,
            'province_id'=> $this->province_id,
            'district_id'=> $this->district_id,
            'address'=> $this->address,
            'email'=> $this->email,
            'telephone'=> $this->telephone,
            'perception_agent'=> $this->perception_agent,
            'state'=> $this->state,
            'condition'=> $this->condition,
            'percentage_perception'=> $this->percentage_perception,
            'person_type_id'=> $this->person_type_id,
            'age'=> $this->age,     
            'sex' => $this->sex,
            'specialty' => $this->specialty->description, 
            'created_at' => \Carbon\Carbon::parse($this->created_at)->format('d-m-Y H:i:s'),
            'updated_at' => \Carbon\Carbon::parse($this->updated_at)->format('d-m-Y H:i:s'),
        ];
    }
}