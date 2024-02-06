<?php

namespace Modules\Restaurant\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Storage;

class HotelRentCustomerReportCollection extends ResourceCollection
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
                'item_count'       => $row->item_count,
                'customer_id'          => $row->customer_id,
                'customer_name' => $row->customer->name,
                'customer_number' => $row->customer->number,
                'total_duration'      => $row->total_duration,
            ];
        });
    }
}
