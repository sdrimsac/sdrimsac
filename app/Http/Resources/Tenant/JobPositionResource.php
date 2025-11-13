<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Module;
use Illuminate\Http\Resources\Json\JsonResource;

class JobPositionResource extends JsonResource
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
                'name'=> $this->name,
                'sueldo_base'=> $this->sueldo_base,
                'factor_diario'=> $this->factor_diario,
                'estado'=> $this->estado,
                'created_at'=> $this->created_at,
                'updated_at'=> $this->updated_at,
        ];
    }
}