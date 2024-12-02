<?php

namespace App\Http\Resources\Tenant;

use Carbon\Carbon;

use Illuminate\Http\Resources\Json\ResourceCollection;

class WarrantyCollection extends ResourceCollection
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

            $fechaFin = Carbon::parse($row->warranty_end_date);
            $fechaInicio = Carbon::parse($row->warranty_start_date);

            if ($fechaFin->isFuture()) {
                $diasRestantes = Carbon::now()->diffInDays($fechaFin);
            } else {
                $diasRestantes = 0;
            }
            return [
                'id' => $row->id,
                'warranty_start_date' => $row->warranty_start_date,
                'warranty_end_date' => $row->warranty_end_date,
                'dias_restantes' => $diasRestantes,
                'sale_note_item_id' => $row->sale_note_item_id,
                'sale_note_item' => $row->saleNoteItem,
                'document_item_id' => $row->document_item_id,
                'document_item' => $row->documentItem,
                'sale_note_customer' => $row->saleNoteItem->sale_note->customer ?? null,
                'document_customer' => $row->documentItem->document->customer ?? null,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ];
        });
    }
}
