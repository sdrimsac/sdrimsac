<?php

namespace Modules\Workshop\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class HistorialItemCollection extends ResourceCollection
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
                'item_id' => $row->item_id,
                'cantidad' => $row->cantidad,
                'precio' => $row->precio,
                'historial_id' => $row->historial_idd,
                'created_at' => $row->created_at,
            ];
        });
    }
}