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

            $productoSaleNote = $row->saleNoteItem->item ?? null;
            $productoDocument = $row->documentItem->item ?? null;
            $clienteSaleNote = $row->saleNoteItem->sale_note->customer ?? null;
            $clienteDocumento = $row->documentItem->document->customer ?? null;
            return [
                'id' => $row->id,
                'warranty_start_date' => $row->warranty_start_date,
                'warranty_end_date' => $row->warranty_end_date,
                'dias_restantes' => $diasRestantes,
                'sale_note_item_id' => $row->sale_note_item_id,
                'document_item_id' => $row->document_item_id,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
                'producto_sale_note' => $productoSaleNote,
                'producto_document' => $productoDocument,
                'sale_note_customer' => $clienteSaleNote,
                'document_customer' => $clienteDocumento,
            ];
        });
    }
}
