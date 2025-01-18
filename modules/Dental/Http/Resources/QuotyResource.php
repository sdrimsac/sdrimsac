<?php

namespace Modules\Dental\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuotyResource extends JsonResource
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
                'patient_id'                => $this->patient_id,
                'medic_id'                  => $this->medic_id,
                'date'                      => $this->date,
                'time'                      => $this->time,
                'price'                     => $this->price,
                'state'                     => $this->state,
                'reason_consultation'       => $this->reason_consultation,
                'observation'               => $this->observation,
        ];
    }
}