<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FoodsShopCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                'id' => $item->food_id,
                'description' => $item->description,
                'quantity' => (float) $item->quantity,
                'price' => (float) $item->price,
                'total' => (float) $item->total,
                'commission' => (float) $item->commission,
                'commission_total' => (float) $item->commission_total,
            ];
        });
    }
}
