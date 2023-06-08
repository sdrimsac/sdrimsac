<?php

namespace Modules\College\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\College\Models\CollegeMember;

class CollegeParentUpdateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $person = $this->person;
        $attorney = $this->attorney;
        $children = CollegeMember::where('parent_id', $this->id)->get()->transform(
            function ($row) {
                //check if in CollegeRegister has a register with member_id = $row->id
                $edit = count($row->registers) > 0 ;
                return [
                    "id" => $row->children_id,
                    "edit" => !$edit,
                    "name" => $row->person->name,
                    "number" => $row->person->number,
                    "identity_document_type_id" => $row->person->identity_document_type_id
                ];
            }
        );
        return [
            'id' => $this->id,
            'identity_document_type_id' => $person->identity_document_type_id,
            'number' => $person->number,
            'email' => $person->email,
            'name' => $person->name,
            'condition' => $person->condition,
            'state' => $person->state,
            'country_id' => $person->country_id,
            'department_id' => $person->department_id,
            'province_id' => $person->province_id,
            'district_id' => $person->district_id,
            'address' => $person->address,
            'phone' => $person->telephone,
            'extra_phone' => $this->extra_phone,
            'type'  => $this->type,
            'attorney_id' => isset($attorney) ? $attorney->id : null,
            'children' => $children,

        ];
    }
}
