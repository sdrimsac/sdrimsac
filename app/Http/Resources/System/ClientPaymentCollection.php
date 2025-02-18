<?php

namespace App\Http\Resources\System;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ClientPaymentCollection extends ResourceCollection
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
            return [
                'id' => $row->id,
                'document' => $row->document,
                'document_url' => $row->document_url,
                'date_of_payment' => $row->date_of_payment->format('d/m/Y'),
                'payment_method_type_description' => $row->payment_method_type->description,
                'card_brand' => $row->card_brand,
                'reference' => $row->reference,
                'payment' => $row->payment, 
                'end_payment' => $row->end_payment ? $row->end_payment->format('d/m/Y') : '',
                'state' => $row->state,
                'state_description' => ($row->state) ? 'Pagado': (($row->date_of_payment >= date('Y-m-d')) ? 'Pendiente':'Vencido'),
            ];
        });
    }
}