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

        return $this->collection->transform(function ($row) {
            $fechaFin = Carbon::parse($row->warranty_end_date);
            $diasRestantes = $fechaFin->isFuture() ? Carbon::now()->diffInDays($fechaFin) : 0;

            $saleNoteItem = $row->saleNoteItem;
            $documentItem = $row->documentItem;

            $item = $saleNoteItem->item ?? $documentItem->item ?? null;
            $customer = $saleNoteItem->sale_note->customer ?? $documentItem->document->customer ?? null;

            $document = $documentItem->document ?? null;
            $saleNote = $saleNoteItem->sale_note ?? null;

            // Obtener serie vendida desde el lote
            $serie_vendida = null;
            

            $documentItem = $row->documentItem;
            if ($row->lot) {
                $serie_vendida = $row->lot->series;
            }

            return [
                'id' => $row->id,
                'warranty_start_date' => $row->warranty_start_date,
                'warranty_end_date' => $row->warranty_end_date,
                'dias_restantes' => $diasRestantes,

                'serie' => $document->series ?? $saleNote->series ?? null,
                'numero' => $document->number ?? $saleNote->number ?? null,
                'fecha_venta' => $document->date_of_issue ?? $saleNote->date_of_issue ?? null,

                'cliente_nombre' => $customer->name ?? null,
                'cliente_numero' => $customer->number ?? null,

                'item_id' => $item->id ?? null,
                'internal_id' => $item->internal_id ?? null,
                'description' => $item->description ?? null,
                'month_day' => $item->month_day ?? null,

                'serie_vendida' => $serie_vendida,

                'sale_note_item_id' => $row->sale_note_item_id,
                'document_item_id' => $row->document_item_id,
                'created_at' => $row->created_at,
            ];
        });
    }
}
