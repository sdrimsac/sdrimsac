<?php

namespace Modules\Workshop\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehiculoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'placa' => $this->placa,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'serie' => $this->serie,
            'color' => $this->color,
            'motor' => $this->motor,
            'anio_fabricacion' => $this->anio_fabricacion,
            'kilometraje' => $this->kilometraje,
        ];
    }
}