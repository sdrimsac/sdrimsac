<?php

namespace Modules\LotItem\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LotItemCollection extends ResourceCollection
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
                'id'          => $row->id,
                'series' => $row->series,
                'date'      => $row->date,
                'item'     => $row->item,
                'warehouse'    => $row->warehouse,
                'lote'    => $row->lote ? $row->lote->code : null,
                'has_sale'    => (bool)$row->has_sale,
                'active'    => $row->state,
            ];
        });
    }
}
