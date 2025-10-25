<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\CreditList;
use App\Models\Tenant\Person;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;

class StaffPersonCollection extends ResourceCollection
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

            Log::info("CreditList for orden_id {$orden_id}: " . ($credit_list ? $credit_list->toJson() : 'null'));

            // Protect against null CreditList: use optional() on the object itself
            $seller = optional(optional($credit_list)->seller)->name;
            $establishment = optional(optional($credit_list)->establishment)->description;
            $credit_list_id = optional($credit_list)->id;

            $price = $row->price;
            $quantity = $row->quantity;
            $total = $price * $quantity;
            $total = number_format($total, 2, ".", "");

            return [
                'id' => $row->id,
                'credit_list_id' => $credit_list_id,
                'seller' => $seller,
                'product' => optional($row->food)->description,
                'price' => $total,
                'quantity' => $row->quantity,
                'establishment' => $establishment,
                'date' => $row->date,
            ];
        });
    }
}