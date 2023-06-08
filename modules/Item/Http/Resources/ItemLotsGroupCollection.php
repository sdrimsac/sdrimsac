<?php

namespace Modules\Item\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ItemLotsGroupCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->transform(function ($row, $key) {

            return [
                'id' => $row->id,
                'lote' => $row->code,
                'item' => $row->item,
                'item_id' => $row->item_id,
                'date_of_due' => Carbon::parse($row->date_of_due)->format("d/m/Y"),
                'warehouse' => $row->warehouse,
                'quantity' => $row->quantity,
                'created_at' => $row->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $row->updated_at->format('Y-m-d H:i:s'),
            ];
        });
    }
}
