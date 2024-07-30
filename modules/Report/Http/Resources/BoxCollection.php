<?php

namespace Modules\Report\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BoxCollection extends ResourceCollection
{
     

    public function toArray($request) {
        

        return $this->collection->transform(function($row, $key){ 
             $customer = null;
             if($row->document){
                $customer = $row->document->customer;
             }else if($row->salenote){
                $customer = $row->salenote->customer;
             }else if($row->sale_note_payment){
                $customer = $row->sale_note_payment->associated_record_payment->customer;
             }
             else if($row->document_payment){
                $customer = $row->document_payment->document->customer;
             }
               $customer_name = ($customer) ? $customer->name : null;
               $customer_document = ($customer) ? $customer->number : null;
            return [
                'id' => $row->id,
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
