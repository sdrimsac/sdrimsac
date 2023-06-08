<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Receipt;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SaleNotePaymentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key) {
            $receipt= Receipt::where('sale_note_payment_id',$row->id)->first();

            $external_id= ($receipt==null) ? "" : url('')."/receipt/print/{$receipt->external_id}";
            return [
                'id' => $row->id,
                'date_of_payment' => $row->date_of_payment->format('d/m/Y'),
                'payment_method_type_description' => $row->payment_method_type->description,
                'destination_description' => ($row->global_payment) ? $row->global_payment->destination_description:null,
                'reference' => $row->reference,
                'filename' => ($row->payment_file) ? $row->payment_file->filename:null,
                'payment' => $row->payment,
                'receipt_link'=>$external_id
            ];
        });
    }
}