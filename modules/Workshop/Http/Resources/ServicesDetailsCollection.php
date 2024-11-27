<?php

namespace Modules\Workshop\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ServicesDetailsCollection extends ResourceCollection
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
                'service_id' => $row->service_id,
                'service_description' => $row->service ? $row->service->description : null,
                'name' => $row->name,
                'description' => $row->description,
                'date_start' => $row->date_start,
                'date_end' => $row->date_end,
                'status' => $row->status,
                'price_unit' => $row->price_unit,
            ];
        });
    }
}