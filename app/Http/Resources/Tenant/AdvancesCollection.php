<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AdvancesCollection extends ResourceCollection
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
                'person_id'=> $row->person_id,
                'person_name'=> $row->person_name ?? optional($row->person)->name,
                'amount'=> $row->amount,
                'method'=> $row->method,
                'date_time_advance'=> $row->date_time_advance,
                'created_at'=> $row->created_at,
                'updated_at'=> $row->updated_at,
            ];
        });
    }
}
