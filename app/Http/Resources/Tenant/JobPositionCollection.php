<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;

class JobPositionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key) {

            return [
                'id' => $row->id,
                'name'=> $row->name,
                'sueldo_base'=> $row->sueldo_base,
                'factor_diario'=> $row->factor_diario,
                'estado'=> $row->estado,
                'created_at'=> $row->created_at,
                'updated_at'=> $row->updated_at,
            ];
        });
    }
}
