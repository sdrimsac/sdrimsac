<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Payment;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\Establishment;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleNoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $establishment = Establishment::where('id', $this->establishment_id)->first();
        $sale_note = SaleNote::find($this->id);

        $establishment = Establishment::where('id', $this->establishment_id)->first();
        // $schedule=Payment::where('id', $this->id)->first();
        return [
            'credit_cash' => (bool) $this->credit_cash,
            'from_consignment' => (bool) $this->from_consignment,
            'id' => $this->id,
            'establishment_description' => $establishment->description,
            'total' => $this->total,
            'external_id' => $this->external_id,
            'format_printer' => $establishment->format_printer,
            'printer' => $establishment->printer,
            'printer_serve' => $establishment->printer_serve,
            'direct_printing' => (bool) $establishment->direct_printing,
            'number' => $this->number,
            'number' => $this->number_full,
            'identifier' => $this->identifier,
            'variation' => $this->variationDocument,
            'date_of_issue' => $this->date_of_issue->format('Y-m-d'),
            //'view_schedule'=> ($schedule==null) ? false : true,
            'print_ticket' => url('') . "/sale-notes/print/{$this->external_id}/ticket",
            'print_a4' => url('') . "/sale-notes/print/{$this->external_id}/a4",
            'print_a5' => url('') . "/sale-notes/print/{$this->external_id}/a5",
            'schedule' => url('') . "/sale-notes/schedule/{$this->id}",
            'sale_note' => $sale_note,
            'serie' => $this->series,
            'number' => $this->number,
            'month'  => $this->month,
            "orden_id" => $this->orden_id
        ];
    }
}
