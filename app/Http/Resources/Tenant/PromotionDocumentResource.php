<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\JsonResource;

class PromotionDocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'total' => $this->total,
            'points_value' => $this->points_value,
            'limit_changes' => $this->limit_changes,
            'items' => $this->items->transform(function ($item) {
                
                return [
                    'id' => $item->item_id,
                    'full_description' => $item->item->internal_id . ' - ' . $item->item->description,
                    'quantity' => $item->quantity,
                    'points_value' => $item->points_value
                ];
            })
        ];
    }
}