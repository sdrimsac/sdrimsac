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
        return $this->collection->transform(function ($row, $key) {
            $historial_id = null;
            $items = 0;
            $historial = $row->historial()->where('estado', false)->latest()->first();
            if ($historial) {
                $historial_id = $historial->id;
                $items = $historial->historialItem->count();
            }
            return [
                'id' => $row->id,
                'historial_id' => $historial_id,
                'customer_id' => $row->customer_id,
                'customer_name' => $row->customer ? $row->customer->name : null,
                'tipo_vehiculo_id' => $row->tipo_vehiculo_id,
                'tipo_vehiculo_description' => $row->tipo_vehiculo ? $row->tipo_vehiculo->description : null,
                'marca' => $row->marca,
                'modelo' => $row->modelo,
                'anio_fabricacion' => $row->anio_fabricacion ? date('Y', strtotime($row->anio_fabricacion)) : null,
                'placa' => $row->placa,
                'kilometraje' => $row->kilometraje,
                'active' => $row->active,
                'serie' => $row->serie,
                'color' => $row->color,
                'motor' => $row->motor,
                'items' => $items,
                'created_at' => $row->created_at->format('d-m-Y H:i'),
            ];
        });
    }
}
