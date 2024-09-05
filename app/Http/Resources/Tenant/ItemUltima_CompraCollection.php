<?php

namespace App\Http\Resources\Tenant;

/* use App\Models\Tenant\Configuration; */
use Illuminate\Http\Resources\Json\ResourceCollection;

class Itemultima_CompraCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->transform(function ($row, $key){
            return [
            'date_of_issue' => $row->date_of_issue,
            'series' => $row->series,
            'number' => $row->number,
            'supplier_name' => $row->supplier_name,
            'supplier_number' => $row->supplier_number,
            'document_type_id' => $row->document_type_id,
            'item_id' => $row->item_id,
            'quantity' => $row->quantity,
            'unit_value' => $row->unit_value,
            'total' => $row->total

            ];
        });
    }
}
