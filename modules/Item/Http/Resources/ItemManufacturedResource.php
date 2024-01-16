<?php

//namespace App\Http\Resources\Tenant;
namespace Modules\Item\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class ItemManufacturedResource extends JsonResource
{

 
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'icono' => $this->icono,
            'image_url' => ($this->icono !== 'imagen-no-disponible.jpg') ? asset('storage/uploads/category/'.$this->icono) : asset("/logo/{$this->icono}"),

        ];
    }



}
