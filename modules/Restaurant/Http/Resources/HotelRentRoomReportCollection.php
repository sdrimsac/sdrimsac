<?php

namespace Modules\Restaurant\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Storage;

class HotelRentRoomReportCollection extends ResourceCollection
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
               'table_id'         => $row->table_id,
               'total_duration'   => $row->total_duration,
               'name'            => "$row->table_name - $row->floor_name - $row->tower_name",
            ];
        });
    }
}
