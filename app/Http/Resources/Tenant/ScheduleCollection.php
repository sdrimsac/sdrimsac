<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ScheduleCollection extends ResourceCollection
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
                'id' => $row->id,
                'person_id' => $row->person_id,
                'person_name' => $row->person_name ?? optional($row->person)->name,

                'name' => $row->name,
                'entrada' => $row->entrada,
                'salida' => $row->salida,
                'tolerancia_min' => $row->tolerancia_min,
                'created_at' => Carbon::parse($row->created_at)->format('Y-m-d H:i'),
                'updated_at' => Carbon::parse($row->updated_at)->format('Y-m-d H:i'),
            ];
        });
    }
}
