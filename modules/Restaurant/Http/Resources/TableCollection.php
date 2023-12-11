<?php

namespace Modules\Restaurant\Http\Resources;

use App\Models\Tenant\Configuration;
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
        $configuration =   Configuration::first();
        $credit_line_hotel_limit = $configuration->credit_line_hotel_limit ?? 150;
        return $this->collection->transform(function ($row, $key) use ($credit_line_hotel_limit) {
            $orden = Orden::where('table_id', $row->id)->where('status_orden_id', '!=', 4)->get();
            $tower = optional(optional($row->floor)->tower)->name;
            return [
                'credit_line_hotel_limit' => $credit_line_hotel_limit,
                'has_frigobar'     => (bool)$row->has_frigobar,
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
                'full_name'       => $row->getTableFullName(),
                'is_room'       => $row->is_room,
            ];
        });
    }
}
