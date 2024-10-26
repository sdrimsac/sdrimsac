<?php

namespace Modules\Workshop\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServicesDetailsResource extends JsonResource
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
            'name' => $this->name,
            'service_id' => $this->service_id,
            'description' => $this->description,
            'service_description' => $this->service ? $this->service->name : null,
            /* 'date_start' => $this->date_start,
            'date_end' => $this->dete_end,
            'status' => $this->status, */
        ];
    }
}