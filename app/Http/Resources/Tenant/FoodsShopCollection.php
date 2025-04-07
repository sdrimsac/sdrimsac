<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FoodsShopCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                'id' => $item->id,
                'description' => optional($item->food)->description,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => $item->quantity * $item->price,
            ];
        });
    }
}
