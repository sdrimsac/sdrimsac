<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\JsonResource;

class CashTransferResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
            return [
                'id' => $this->id,
                'cash_principal' => $this->cash_principal,
                'cash_destination' => $this->cash_destination,
                'date_of_issue' => $this->date_of_issue,
                'observation' => $this->observation,
                'amount' => $this->amount,
            ];

        
    }
}