<?php

namespace Modules\Vip\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VipCollection extends ResourceCollection
{

    public function toArray($request)
    {
        return $this->collection->transform(function ($row, $key) {

            return [
                'id' => $row->id,
                'description' => $row->description,
                'percentage' => $row->percentage,
                'inscription_amount' => $row->inscription_amount,
                'active' => $row->active,
                'created_at' => $row->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $row->updated_at->format('Y-m-d H:i:s'),
            ];
        });
    }
}
