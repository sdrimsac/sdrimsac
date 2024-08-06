<?php

namespace Modules\Report\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BoxCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key) {
            $customer = null;
            $external_id = null;
            $documen_type_id = "80";
            if ($row->document) {
                $external_id = $row->document->external_id;
                $documen_type_id = $row->document->document_type_id;
                $customer = $row->document->customer;
            } elseif ($row->saleNote) {
                $customer = $row->saleNote->customer;
                $external_id = $row->saleNote->external_id;
            } elseif ($row->sale_note_payment && $row->sale_note_payment->associated_record_payment) {
                $customer = $row->sale_note_payment->associated_record_payment->customer;
                $external_id = $row->sale_note_payment->associated_record_payment->external_id;
            } elseif ($row->document_payment && $row->document_payment->document) {
                $customer = $row->document_payment->document->document_type_id;
                $customer = $row->document_payment->document->customer;
                $external_id = $row->document_payment->document->external_id;
            }

            $customer_name = $customer ? $customer->name : null;
            $customer_document = $customer ? $customer->number : null;

            return [
                'external_id' => $external_id,
                'id' => $row->id,
                'document_type_id' => $documen_type_id,
                'customer_name' => $customer_name,
                'customer_document' => $customer_document,
                'date' => $row->date,
                'amount' => $row->amount,
                'method' => $row->method,
                'operation_number' => $row->operation_number,
                'user' => $row->user->name,
                'time' => $row->created_at->format('H:i:s'),
            ];
        });
    }
}

