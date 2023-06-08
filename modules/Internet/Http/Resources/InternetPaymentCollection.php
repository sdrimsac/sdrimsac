<?php

namespace Modules\Internet\Http\Resources;


use Illuminate\Http\Resources\Json\ResourceCollection;

class InternetPaymentCollection extends ResourceCollection
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
            // $house_photo = null;
            return [
                'id'          => $row->id,
                'document' => $row->document,
                'sale_note' => $row->sale_note,
                'months' => $row->months,
                'rest' => $row->rest,

            ];
        });
    }
}
