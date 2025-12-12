<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PersonStaffCollection extends ResourceCollection
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
            
                'image' => $row->image,
                'document_type_id' => $row->document_type_id,
                'alias' => $row->alias,
                'adderss_secondary' => $row->adderss_secondary,
                'credit_line' => $row->credit_line,
                'has_credit_line' => (bool) $row->has_credit_line,
                'id' => $row->id,
                'type' => $row->type,
                'identity_document_type_id' => $row->identity_document_type_id,
                'number' => $row->number,
                'name' => $row->name,
                'trade_name' => $row->trade_name,
                'country_id' => $row->country_id,
                'department_id' => $row->department_id,
                'province_id' => $row->province_id,
                'district_id' => $row->district_id,
                'address' => $row->address,
                'email' => $row->email,
                'telephone' => $row->telephone,
                'perception_agent' => $row->perception_agent,
                'state' => $row->state,
                'condition' => $row->condition,
                'percentage_perception' => $row->percentage_perception,
                'person_type_id' => $row->person_type_id,
                'comment' => $row->comment,
                'enabled' => (bool) $row->enabled,
                'user_name' => $row->user ? $row->user->name : '',
                'occupation' => $row->occupation,
                'job_position' => $row->job_position->name,
                'job_position_salary' => $row->job_position->sueldo_base,
                'image_url' => ($row->image !== 'user.png') ? asset('storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'persons' . DIRECTORY_SEPARATOR . $row->image) : asset("/status_images/{$row->image}"),
            ];
        });
    }
}
