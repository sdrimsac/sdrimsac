<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SellerCollection extends ResourceCollection
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
                'name' => $row->name,
                'document' => $row->document,
                'telephone' => $row->telephone,
                'establishment_description' => optional($row->establishment)->description ?? '-',
                'active' => (bool) $row->active,
            ];
        });
    }
}