<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\JsonResource;

class WarrantyResource extends JsonResource
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
            'warranty_start_date' => $this->warranty_start_date,
            'warranty_end-date' => $this->warranty_end_date,
            'sale_note_item_id' => $this->sale_noyte_item_id,
            'document_item_id' => $this->document_item_id,
        ];
    }
}
