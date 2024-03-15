<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\JsonResource;

class PrincipalCategoriesResource extends JsonResource
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
            'id'            => $this->id,
            'name'      => $this->name,
            'identifier'      => $this->identifier,
            'is_expanded' => (bool) $this->is_expanded,
            'active' => (bool) $this->active,
        ];
    }
}
