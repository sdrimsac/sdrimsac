<?php

namespace Modules\Report\Http\Resources;

use Carbon\Carbon;
use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant\DocumentPayment;
use App\Models\Tenant\SaleNotePayment;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DocumentCollection extends ResourceCollection
{


    public function toArray($request) {


             return $this->collection->transform(function($row, $key) {
                // dd(json_decode($row->customer,true));
                $affected_document = null;
        if(in_array($row->document_type_id,['07','08']) && $row->note){

                $series = ($row->note->affected_document) ? $row->note->affected_document->series : $row->note->data_affected_document->series;
                $number =  ($row->note->affected_document) ? $row->note->affected_document->number : $row->note->data_affected_document->number;
                $affected_document = $series.' - '.$number;
        }
            $signal = $row->document_type_id;
            $state = $row->state_type_id;
        if($row->payment_id=="payment_id"){
            $status_payment= "PENDIENTE";
            $date_payment="";
            $hora_pago="";
            $deuda= $row->total;
            $total_advances=0;
        }else{
            if($row->document_type_id=="80"){
                    $saleNote=SaleNotePayment::where('sale_note_id',$row->id)->first();

                    if($saleNote){
                        $date_payment=$saleNote->date_of_payment->format('d-m-Y');
                        $hora_pago=\Carbon\Carbon::parse($saleNote->created_at)->format('H:i:s');
                        $payments=SaleNotePayment::select('payment')->where('sale_note_id',$row->id)->where('id',$row->payment_id)->first();
                        $total_advances=$payments->payment;
                        $deuda= $row->total - $total_advances;
                        if($deuda==0){
                            $status_payment="PAGADO";
                        }else{
                            $status_payment= "PENDIENTE";
                        }
                    }else{
                        $status_payment= "PENDIENTE";
                        $date_payment="";
                        $hora_pago="";
                        $deuda= $row->total;
                        $total_advances=0;
                    }

            }else{
                if($row->document_type_id=="01" || $row->document_type_id=="03"){
                    $documents_payment=DocumentPayment::where('document_id',$row->id)->first();
                    if($documents_payment){
                        $date_payment=$documents_payment->date_of_payment->format('d-m-Y');
                        $hora_pago=\Carbon\Carbon::parse($documents_payment->created_at)->format('H:i:s');
                        $payments=DocumentPayment::select(DB::raw('SUM(payment) as payment'))->where('document_id',$row->id)->where('id',$row->payment_id)->first();
                        $total_advances=$payments->payment;
                        $deuda= $row->total - $total_advances;
                        if($deuda==0){
                            $status_payment="PAGADO";
                        }else{
                            $status_payment= "PENDIENTE";
                        }
                    }else{
                        $status_payment= "PENDIENTE";
                        $date_payment="";
                        $hora_pago="";
                        $deuda= $row->total;
                        $total_advances=0;
                    }
                }
            }
        }
        if($row->document_type_id=="01"){
            $document_type_description="FACTURA ELECTRONICA";
            $document_type_id="01";
        }else if($row->document_type_id=="03"){
            $document_type_description="BOLETA DE VENTA";
            $document_type_id="03";

        }else {
            $document_type_description="NOTA DE VENTA";
            $document_type_id="80";

        }
            return [
                'id' => $row->id,
                'soap_type_id' => $row->soap_type_id,
               // 'soap_type_description' => $row->soap_type->description,
                'date_of_issue' => $row->date_of_issue,
                'date_payment'=> $date_payment,
                'hora_pago'=>$hora_pago,
                'number' => $row->number,
                'customer_name' => json_decode($row->customer,true)['name'], //$row->customer->name,
                'customer_number' => json_decode($row->customer,true)['number'],
                'deuda' => $deuda,
                'status_payment'=>$status_payment,
                'series' => $row->series,
                'alone_number' => $row->number,

                'total_exportation' => (in_array($row->document_type_id,['01','03','80']) && in_array($row->state_type_id,['09','11'])) ? number_format(0,2, ".","") : number_format($row->total_exportation,2, ".",""),
                'total_exonerated' =>  (in_array($row->document_type_id,['01','03','80']) && in_array($row->state_type_id,['09','11'])) ? number_format(0,2, ".","") : number_format($row->total_exonerated,2, ".",""),
                'total_unaffected' =>  (in_array($row->document_type_id,['01','03','80']) && in_array($row->state_type_id,['09','11'])) ? number_format(0,2, ".","") : number_format($row->total_unaffected,2, ".",""),
                'total_free' =>  (in_array($row->document_type_id,['01','03','80']) && in_array($row->state_type_id,['09','11'])) ? number_format(0,2, ".","") : number_format($row->total_free,2, ".",""),
                'total_taxed' => (in_array($row->document_type_id,['01','03','80']) && in_array($row->state_type_id,['09','11'])) ? number_format(0,2, ".","") : number_format($row->total_taxed,2, ".",""),
                'total_igv' =>  (in_array($row->document_type_id,['01','03','80']) && in_array($row->state_type_id,['09','11'])) ? number_format(0,2, ".","") : number_format($row->total_igv,2, ".",""),
                'total' =>  $row->total,
                'advances'=> $total_advances,
                'state_type_id' => $row->state_type_id,
                'document_type_description' => $document_type_description,
                'document_type_id' => $document_type_id,
                'pendient'=>$status_payment,
                'affected_document' => $affected_document,
               // 'user_name' => ($row->user) ? $row->user->name : '',
               // 'user_email' => ($row->user) ? $row->user->email : '',
              //  'quotation_number_full' => ($row->quotation) ? $row->quotation->number_full : '',
              //  'sale_opportunity_number_full' => isset($row->quotation->sale_opportunity) ? $row->quotation->sale_opportunity->number_full : '',

            ];
        });
    }
}
