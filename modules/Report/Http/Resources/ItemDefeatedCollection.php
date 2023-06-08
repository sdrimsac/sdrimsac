<?php

namespace Modules\Report\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ItemDefeatedCollection extends ResourceCollection
{
     

    public function toArray($request) {
        

        return $this->collection->transform(function($row, $key){ 
             
               
            return [
                'id' => $row->id, 
                'date_of_due' => Carbon::parse($row->date_of_due)->format('d-m-Y'),//$row->date_of_due,
                'description' => $row->description,
                'internal_id' => $row->internal_id,
                'unit_type_id' => $row->unit_type_id,
                'currency_type_id' => $row->currency_type_id,
                'sale_unit_price' => number_format($row->sale_unit_price,2),
                'purchase_unit_price' => number_format($row->purchase_unit_price,2),
                'stock' => $row->stock,
            ];
        });
    }
}
