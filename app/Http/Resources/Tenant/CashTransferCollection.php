<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CashTransferCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->collection->transform(function ($row, $key) {

            
            return [
                'id' => $row->id,
                'cash_principal' => $row->cash_principal,
                'cash_destination' => $row->cash_destination->reference_number,
                'user_destination' => $row  ->cash_destination->user->name,
                'date_of_issue' => $row->date_of_issue,
                'observation' => $row->observation,
                'amount' => number_format($row->amount, 2, ".", ""),
            ];
        });
    }
}
