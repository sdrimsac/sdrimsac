<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\JsonResource;

class VaultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key) {

          

            return [
                'date'=> $this->date,
                'amount'=> $this->amount,
                'destination'=> $this->destination,
                'movement'=> $this->movement,
            ];
        });
    }
}
