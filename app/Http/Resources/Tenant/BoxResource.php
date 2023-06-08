<?php

namespace App\Http\Resources\Tenant;
use Illuminate\Http\Resources\Json\JsonResource;

class BoxResource extends JsonResource
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
            'id'                => $this->id,
            'groups'            => $this->groups,
            'categories'        => $this->categories,
            'subcategories'     => $this->subcategories,
            'group_id'          => $this->group_id,
            'category_id'       => $this->category_id,
            'subcategory_id'    => $this->subcategory_id,
            'amount'            => $this->amount,
            'date'              => $this->date,
            'description'      => $this->description,
        ];
    }
}