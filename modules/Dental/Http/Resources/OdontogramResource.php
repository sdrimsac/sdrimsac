<?php

namespace Modules\Dental\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OdontogramResource extends JsonResource
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
            'id' => $this->idks,
            'patient_id' => $this->patient_id,
            'tooth'      => $this->tooth,
            'data'       => $this->data,
        ];
    }
}