<?php

namespace Modules\Dental\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TariffCollection extends ResourceCollection
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
                'id'           => $row->id,
                'process'      => $row->process,
                'category'     => $row->category,
                'category_id'  => $row->category_id,
                'price'        => $row->price,
                'measure'      => $row->measure,
                'type_concept' => $row->type_concept,
                'state'        => $row->state,
                'code'         => $row->code,
                'discount'     => $row->discount,
            ];
        });
    }
}
