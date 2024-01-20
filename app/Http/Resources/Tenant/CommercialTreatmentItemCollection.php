<?php

namespace App\Http\Resources\Tenant;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommercialTreatmentItemCollection extends ResourceCollection
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
                'item' => $row->item,
                'item_id' => $row->item_id,
                'commercial_treatment_id' => $row->commercial_treatment_id,
                'amount' =>  $row->amount,
                'active' => (bool) $row->active,
            ];
        });
    }
}