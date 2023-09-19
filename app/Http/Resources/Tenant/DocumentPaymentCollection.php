<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Establishment;
use App\Models\Tenant\Receipt;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DocumentPaymentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        //receipt/print/a1231acd-7fcc-435e-9cab-831dc861d67b

        return $this->collection->transform(function($row, $key) {
            $receipt = Receipt::where('document_payment_id', $row->id)->first();
            $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
            return [
                'printer' => $establishment->printer,
                'id' => $row->id,
                'receipt_file' => $receipt ? url("")."/receipt/print/".$receipt->external_id : null,
                'receipt' =>$receipt ? "RC01-". $receipt->number  : null,
                'date_of_payment' => $row->date_of_payment->format('d/m/Y'),
                'payment_method_type_description' => $row->payment_method_type->description,
                'destination_description' => ($row->global_payment) ? $row->global_payment->destination_description:null,
                'reference' => $row->reference,
                'filename' => ($row->payment_file) ? $row->payment_file->filename:null,
                'payment' => $row->payment,
            ];
        });
    }
}