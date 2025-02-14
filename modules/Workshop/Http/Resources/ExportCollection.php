<?php

namespace Modules\Workshop\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ExportCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key) {
            return [
                'id' => $row->id,
                'personal' => optional($row->personal)->name,
                'customer' => optional($row->vehiculo->customer)->name,
                'tipo_vehiculo' => optional($row->vehiculo->tipo_vehiculo)->name,
                'placa' => optional($row->vehiculo)->placa,
                'serie' => optional($row->vehiculo)->serie,
                'modelo' => optional($row->vehiculo)->modelo,
                'historialServiceDetails' => $row->historialServiceDetails->map(function($detail) {
                    return [
                        'name' => optional($detail->serviceDetail)->name,
                        'price_unit' => optional($detail->serviceDetail)->price_unit,
                    ];
                }),
            ];
        });
    }
}
