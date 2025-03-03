<?php

namespace Modules\Dental\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Medic_DetaislCollection extends ResourceCollection
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
                'medic_id'=> $row->medic_id,
                'day_of_week'=> $row->day_of_week,
                'date'=> $row->date,
                'start_time'=> $row->start_time,
                'end_time'=> $row->end_time,
                'status'=> $row->status,
                'active'=> $row->active,
                'medic' => $row->medic ? $row->medic->name : null,
                'created_at' => \Carbon\Carbon::parse($row->created_at)->format('d-m-Y H:i:s'),
                'updated_at' => \Carbon\Carbon::parse($row->updated_at)->format('d-m-Y H:i:s'),
            ];
        });
    }
}