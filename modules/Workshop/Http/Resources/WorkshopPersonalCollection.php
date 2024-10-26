<?php

namespace Modules\Workshop\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class WorkshopPersonalCollection extends ResourceCollection
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
                'number' => $row->number,
                'telephone' => $row->telephone,
                'establishment_description' => optional($row->establishment)->description ?? '-',
                'active' => (bool) $row->active,
            ];
        });
    }
}