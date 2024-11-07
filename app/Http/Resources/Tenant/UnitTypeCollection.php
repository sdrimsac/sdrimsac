<?php

namespace App\Http\Resources\Tenant;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UnitTypeCollection extends ResourceCollection
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
                'active' => ($row->active)?'Si':'No',
                'symbol' => $row->symbol,
                'description' => $row->description,
                'created_at' => Carbon::parse($row->created_at)->format('Y-m-d H:i'),
                'updated_at' => $row->updated_at,
            ];
        });
    }
}