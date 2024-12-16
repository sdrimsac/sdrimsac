<?php

namespace App\Http\Resources\Tenant;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DigitalPaymentCollection extends ResourceCollection
{
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key) {
            return [
                'id' => $row->id,
                'type' => $row->type,
                'title' => $row->title,
                'person_name' => $row->person_name,
                'amount' => $row->amount,
                'created_at' => $row->created_at->format('Y-m-d H:i:s'),
            ];
        });
    }
}