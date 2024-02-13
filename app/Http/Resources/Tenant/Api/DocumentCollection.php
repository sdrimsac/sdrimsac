<?php

namespace App\Http\Resources\Tenant\Api;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DocumentCollection extends ResourceCollection
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
                'id' => $row->id,
                'external_id' => $row->external_id,
                'total_taxed' => number_format($row->total_taxed, 2),
                'total_igv' => number_format($row->total_igv, 2),
                'total' => number_format($row->total, 2),
                'customer_number' => $row->customer->number,
                'customer_name' => $row->customer->name,
                'date_of_issue' => $row->date_of_issue,
                'full_number' => $row->series . '-' . $row->number,
                'state_type_description' => $row->state_type->description,
                'state_type_id' => $row->state_type_id,
                'items' => $row->items->transform(function($row) {
                    return [
                        'id' => $row->id,
                        'item_id' => $row->item_id,
                        'quantity' => $row->quantity,
                        'unit_price' => $row->unit_price,
                        'total' => $row->total,
                        'description' => $row->item->description,
                    
                    ];
                }),
            ];
        });
    }


}
