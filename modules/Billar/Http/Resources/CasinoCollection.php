<?php

namespace Modules\Billar\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CasinoCollection extends ResourceCollection
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
                'table_id' => $row->table_id,
                'customer_id' => $row->customer_id,
                'reference' => $row->reference,
                'date_start' => $row->date_start,
                'time_start' => $row->time_start,
                'minutes' => $row->minutes,
                'date_end' => $row->date_end,
                'time_end' => $row->time_end,
                'active' => $row->active,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
                /* 'active' => (bool) $row->active, */
            ];
        });
    }
}