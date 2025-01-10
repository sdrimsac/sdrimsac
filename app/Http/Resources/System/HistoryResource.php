<?php

namespace App\Http\Resources\System;

use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends JsonResource
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
            'number' => $this->number,
            'business_id' => $this->business_id,
            'telephone' => $this->telephone,
            'direccion' => $this->direccion,
            'direccion_secondary' => $this->direccion_secondary,
            'email' => $this->email,
            'ruc' => $this->ruc,
            'user' => $this->user,
            'password' => $this->password,
            'user_secondary' => $this->user_secondary,
            'password_secondary' => $this->password_secondary,
            'password_certificate' => $this->password_certificate,
            'date_certificate' => $this->date_certificate,  
        ];
    }
}