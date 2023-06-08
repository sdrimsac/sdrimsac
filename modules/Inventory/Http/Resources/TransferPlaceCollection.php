<?php

namespace Modules\Inventory\Http\Resources;

use Modules\Inventory\Models\Warehouse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransferPlaceCollection extends ResourceCollection
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
            $quantity = 0;
            return [
                'id' => $row->id,
                'code' => $row->code,
                'quantity' => round($row->quantity, 1),
                'warehouse' => $row->warehouse->description,
                'warehouse_destination' => $row->warehouse_destination->description,
                'sender' => $row->sender->name,
                'status' => $row->status,
                'created_at' => $row->created_at->format('Y-m-d H:i:s'),

                'detail' => $row->detail->transform(function ($o) use ($row, &$quantity) {
                    $quantity += $o->quantity;
                    return [
                        'id' => $o->id,
                        'description' => $o->item->description ?? "-",
                        'quantity' => $o->quantity,
                        'lots_enabled' => (bool)$o->item->lots_enabled,
                        'lots' => $o->item->item_lots->where('has_sale', false)->where('warehouse_id', $row->warehouse_destination_id)->transform(function ($row) {
                            return [
                                'id' => $row->id,
                                'series' => $row->series,
                                'date' => $row->date,
                                'item_id' => $row->item_id,
                                'warehouse_id' => $row->warehouse_id,
                                'has_sale' => (bool)$row->has_sale,
                                'lot_code' => ($row->item_loteable_type) ? (isset($row->item_loteable->lot_code) ? $row->item_loteable->lot_code : null) : null
                            ];
                        }),
                    ];
                }),
                'quantity' => $quantity,
            ];
        });
    }
}
