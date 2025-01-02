<?php

namespace App\Http\Resources\Tenant;

use Carbon\Carbon;

use Illuminate\Http\Resources\Json\ResourceCollection;

class WarrantyBoxCollection extends ResourceCollection
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

            $numeroSaleNote = $row->saleNoteItem->sale_note->number ?? null;
            $numeroDocumento = $row->documentItem->document->number ?? null;
            $serieSaleNote = $row->saleNoteItem->sale_note->series ?? null;
            $seriesDocumento = $row->documentItem->document->series ?? null;
            return [
                'id' => $row->id,
                'warranty_start_date' => $row->warranty_start_date,
                'warranty_end_date' => $row->warranty_end_date,
                'dias_restantes' => $diasRestantes,
                'sale_note_item_id' => $row->sale_note_item_id,
                'document_item_id' => $row->document_item_id,
                'producto_sale_note' => $productoSaleNote,
                'producto_document' => $productoDocument,
                'sale_note_customer' => $clienteSaleNote,
                'document_customer' => $clienteDocumento,
                'sale_note_number' => $numeroSaleNote,
                'document_number' => $numeroDocumento,
                'sale_note_series' => $serieSaleNote,
                'document_series' => $seriesDocumento,
            ];
        });
    }
}
