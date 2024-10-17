<?php

namespace Modules\Workshop\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VehiculoCollection extends ResourceCollection
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
                'customer_id' => $row->customer_id,
                'tipo_vehiculo_id' => $row->tipo_vehiculo_id,
                'marca' => $row->marca,
                'modelo' => $row->modelo,
                'anio_fabricacion' => $row->anio_fabricacion,
                'placa' => $row->placa,
                'kilometraje' => $row->kilometraje,
                'active' => $row->active,
                'serie' => $row->serie,
                'color' => $row->color,
                'motor' => $row->motor,
            ];
        });
    }
}