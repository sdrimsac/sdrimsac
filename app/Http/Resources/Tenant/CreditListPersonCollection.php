<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\CreditList;
use App\Models\Tenant\Person;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CreditListPersonCollection extends ResourceCollection
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
            $orden_id = $row->orden_id;
            $credit_list = CreditList::where('orden_id', $orden_id)->first();
            $seller = optional($credit_list->seller)->name;
            $establishment = optional($credit_list->establishment)->description;
            $price = $row->price;
            $quantity = $row->quantity;
            $total = $price * $quantity;
            $total = number_format($total, 2, ".", "");
            return [
                'id' => $row->id,
                'seller' => $seller,
                'product' => optional($row->food)->description,
                'price' => $total,
                'quantity' => $row->quantity,
                'establishment' => $establishment,               
            ];
        });
    }
}