<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PromotionDocumentCollection extends ResourceCollection
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
                'description' => $row->description,
                'date_start' => $row->date_start,
                'date_end' => $row->date_end,
                'total' => $row->total,
                'points_value' => $row->points_value
            
            ];
        });
    }
}