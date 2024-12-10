<?php

namespace Modules\Billar\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TarifaCasinoResource extends JsonResource
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
            'hora' => $this->hora,
            'media_hora' => $this->media_hora,
            'cuarto_hora' => $this->cuarto_hora,
            'active' => $this->active
        ];
    }
}