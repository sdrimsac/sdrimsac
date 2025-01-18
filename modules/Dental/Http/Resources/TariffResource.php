<?php

namespace Modules\Dental\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TariffResource extends JsonResource
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
            'id'           => $this->id,
            'process'      => $this->process,
            'category'     => $this->category,
            'price'        => $this->price,
            'measure'      => $this->measure,
            'type_concept' => $this->type_concept,
            'state'        => $this->state,
            'code' => $this->code,
            'discount' => $this->discount
        ];
    }
}