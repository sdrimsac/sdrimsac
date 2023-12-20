<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ItemClientCollection extends ResourceCollection
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
//            dd($row);
            return [
           
                'customer_name' => $row->customer_name,
                'customer_id' => $row->customer_id,
                'customer_number' => $row->customer_number,
                'series' => $row->series,
                'number' => $row->number,
                'total_quantity' => $row->total_quantity,
                'total' => $row->total,
             
            ];
        });
    }
}