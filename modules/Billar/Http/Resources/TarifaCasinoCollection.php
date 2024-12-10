<?php

namespace Modules\Billar\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TarifaCasinoCollection extends ResourceCollection
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
                'hora' => $row->hora,
                'media_hora' => $row->media_hora,
                'cuarto_hora' => $row->cuarto_hora,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
                /* 'active' => (bool) $row->active, */
            ];
        });
    }
}