<?php

namespace Modules\Inventory\Http\Resources;

use App\Models\Tenant\Item;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Item\Models\ItemLot;

class InventoryTransactionCollection extends ResourceCollection
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
                'name' => $row->name,
                'type' => $row->type == 'output' ? 'Salida' : 'Entrada',
            ];
        });
    }
}
