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
            $tower = optional(optional($row->floor)->tower)->name;
            return [
                'month_price'      => $row->month_price,
                'price'            => $row->price,
                'id'                => $row->id,
                'number'            => $row->number,
                'area'              => $row->area,
                'type'              => optional($row->type)->name,
                'floor'            =>  optional($row->floor)->name,
                'tower'            =>  $tower,
                'status_table'     => $row->status_table,
                'establishment'     => $row->establishment ? $row->establishment->description : null,
                'establishment_id'  => $row->establishment_id,
                'description'      => $row->description,
                'orden'          => $orden,
            ];
        });
    }
}
