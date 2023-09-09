<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
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
            'document' => $this->document,
            'telephone' => $this->telephone,
            'establishment_id' => $this->establishment_id,
            'document_type_id' => $this->document_type_id,
            // 'establishment_description' => optional($this->establishment)->description ?? '-',
            'active' => (bool) $this->active,
        ];
    }
}