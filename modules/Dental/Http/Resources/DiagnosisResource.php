<?php

namespace Modules\Dental\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiagnosisResource extends JsonResource
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
                'cie10'         => $this->cie10,
                'description'   => $this->description,
                'state'         => $this->state,
        ];
    }
}