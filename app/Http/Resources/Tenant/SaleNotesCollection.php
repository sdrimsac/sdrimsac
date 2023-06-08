<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SaleNotesCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key) {
 
            switch ($row->document_type_id) {
                case '01':
                    $document = 'FACTURA ELECTRONICA';
                break;
                case '03':
                    $document = 'BOLETA DE VENTA ELECTRONICA';
                break;
                case '80':
                    $document = 'NOTA DE VENTA';
                break;
            }
            switch ($row->soap_type_id) {
                case '01':
                    $soap_type_description = 'Demo';
                break;
                case '02':
                    $soap_type_description = 'Producción';
                break;
                case '03':
                    $soap_type_description = 'Interno';
                break;
            }
            switch ($row->state_type_id) {
                case '01':
                    $state_type_description = 'Registrado';
                break;
                case '03':
                    $state_type_description = 'Enviado';
                break;
                case '05':
                    $state_type_description = 'Aceptado';
                break;
                case '07':
                    $state_type_description = 'Observado';
                break;
                case '09':
                    $state_type_description = 'Rechazado';
                break;
                case '11':
                    $state_type_description = 'Anulado';
                break;
                case '13':
                    $state_type_description = 'Por anular';
                break;
                default:

                $state_type_description = '';
        
                break;
            }

            $user_sale=User::where('id',$row->user_id)->first();
            
            return [
                 'soap_type_id' =>$row->soap_type_id,
                 'user_name' => $user_sale['name'],
                'document_type_id'=>$row->document_type_id,
                'soap_type_description' => $soap_type_description,
                'date_of_issue' => $row->date_of_issue,
                'number' =>$row->series."-". $row->number,
                'state_type_id'=> $row->state_type_id,
               'customer_name' =>  json_decode($row->customer)->name,
                'customer_number' =>json_decode($row->customer)->number,
                'currency_type_id' => $row->currency_type_id,
                'series' => $row->series,
                'alone_number' => $row->number,
                'total_exportation' => (in_array($row->document_type_id,['01','03','80']) && in_array($row->state_type_id,['09','11'])) ? number_format(0,2, ".","") : number_format($row->total_exportation,2, ".",""),
                'total_exonerated' =>  (in_array($row->document_type_id,['01','03','80']) && in_array($row->state_type_id,['09','11'])) ? number_format(0,2, ".","") : number_format($row->total_exonerated,2, ".",""),
                'total_unaffected' =>  (in_array($row->document_type_id,['01','03','80']) && in_array($row->state_type_id,['09','11'])) ? number_format(0,2, ".","") : number_format($row->total_unaffected,2, ".",""),
                'total_free' =>  (in_array($row->document_type_id,['01','03','80']) && in_array($row->state_type_id,['09','11'])) ? number_format(0,2, ".","") : number_format($row->total_free,2, ".",""),
                'total_taxed' => (in_array($row->document_type_id,['01','03','80']) && in_array($row->state_type_id,['09','11'])) ? number_format(0,2, ".","") : number_format($row->total_taxed,2, ".",""),
                'total_igv' =>  (in_array($row->document_type_id,['01','03','80']) && in_array($row->state_type_id,['09','11'])) ? number_format(0,2, ".","") : number_format($row->total_igv,2, ".",""),
                'total' =>  (in_array($row->document_type_id,['01','03','80']) && in_array($row->state_type_id,['09','11'])) ? number_format(0,2, ".","") : number_format($row->total,2, ".",""),
                'state_type_id' => $row->state_type_id,
                'state_type_description' =>$state_type_description,
           

            ];
        });
    }

}
