<?php

namespace App\Http\Resources\System;

use Illuminate\Http\Resources\Json\ResourceCollection;

class HistoryCollection extends ResourceCollection
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
                'name' => $row->name,
                'number' => $row->number,
                'business_id' => $row->business_id,
                'telephone' => $row->telephone,
                'direccion' => $row->direccion,
                'direccion_secondary' => $row->direccion_secondary,
                'email' => $row->email,
                'ruc' => $row->ruc,
                'user' => $row->user,
                'password' => $row->password,
                'user_secondary' => $row->user_secondary,
                'password_secondary' => $row->password_secondary,
                'password_certificate' => $row->password_certificate,
                'date_certificate' => $row->date_certificate,
            ];
        });
    }
}