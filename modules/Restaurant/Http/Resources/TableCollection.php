<?php

namespace Modules\Restaurant\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Restaurant\Models\Orden;

class TableCollection extends ResourceCollection
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
            $orden = Orden::where('table_id', $row->id)->where('status_orden_id', '!=', 4)->get();
            return [
                'price'            => $row->price,
                'id'                => $row->id,
                'number'            => $row->number,
                'area'              => $row->area,
                'type'              => optional($row->type)->name,
                'floor'            =>  optional($row->floor)->name,
                'status_table'     => $row->status_table,
                'establishment'     => $row->establishment ? $row->establishment->description : null,
                'establishment_id'  => $row->establishment_id,
                'orden'          => $orden,
            ];
        });
    }
}
