<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PersonCollection extends ResourceCollection
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
                'zone' => $row->zone,
                'zone_description' => optional($row->zone)->description,
                'created_at' => $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '',
                'updated_at' => $row->updated_at ? $row->updated_at->format('Y-m-d H:i:s') : '',
            ];
        });
    }
}
