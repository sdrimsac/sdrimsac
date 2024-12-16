<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BankAccountCollection extends ResourceCollection
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
                'bank_description' => $row->bank->description,
                'description' => $row->description,
                'number' => $row->number,
                'cci' => $row->cci,
                'currency_type_description' => $row->currency_type->description,
                'balance' => $row->balance,
                'user_name' => $row->user ? $row->user->name : '',
                'created_at' => $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : null,
                'updated_at' => $row->updated_at ? $row->updated_at->format('Y-m-d H:i:s') : null,
            ];
        });
    }
}