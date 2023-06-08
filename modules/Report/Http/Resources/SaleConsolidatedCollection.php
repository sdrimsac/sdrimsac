<?php

namespace Modules\Report\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SaleConsolidatedCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key){ 
             return [
                'id' => $row->id,
                'item_description' => $row->item->description,
                //'unit_price' => $row->item->sale_unit_price,   
                //'total'=> $row->item->sale_unit_price*$row->quantity,   
                'item_quantity' => $row->quantity,  
                'series' => $row->series ?? 'NV',
                'number' => $row->number ?? $row->id,
                'date_of_issue' => $row->date_of_issue,
               
            ];
        });
    }
    
}
