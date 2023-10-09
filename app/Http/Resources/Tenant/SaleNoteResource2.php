<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Box;
use App\Models\Tenant\Series;
use App\Models\Tenant\Payment;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\Establishment;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;


class SaleNoteResource2 extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $establishment=Establishment::where('id', $this->establishment_id)->first();
        $serie = Series::where('number', $this->series)->first();
        $boxes = Box::where('sale_note_id', $this->id)->count();
        $payments=Payment::where('sale_note_id',$this->id)->first();
        if($payments==null){
            $tasa=0;
        }else{
            $tasa=$payments->tasa;
        }
        if($boxes>0){
            $afectar_caja=true;
        }else{
            $afectar_caja=false;
        }

        return [
            'establishment_id' => $this->establishment_id,
            'format_printer'=>$establishment->format_printer,
            'printer'=>$establishment->printer,
            'printer_serve' => $establishment->printer_serve,
            'direct_printing'=>(bool) $establishment->direct_printing,
            'number' => $this->number,
            'series_id' => ($serie) ? $serie->id : null,
            'id' => $this->id,
            'prefix' => $this->prefix,
            'establishment_id' => $this->establishment_id,
            'date_of_issue' => $this->date_of_issue->format('Y-m-d'),
            'time_of_issue' => $this->time_of_issue,
            'customer_id' => $this->customer_id,
            'customer'=>$this->customer,
            'currency_type_id' => $this->currency_type_id,
            'purchase_order' => $this->purchase_order,
            'exchange_rate_sale' => $this->exchange_rate_sale,
            'total_prepayment' => $this->total_prepayment,
            'total_charge' => $this->total_charge,
            'total_discount' => $this->total_discount,
            'total_exportation' => $this->total_exportation,
            'total_free' => $this->total_free,
            'total_taxed' => $this->total_taxed,
            'total_unaffected' => $this->total_unaffected,
            'total_exonerated' => $this->total_exonerated,
            'total_igv' => $this->total_igv,
            'total_base_isc' => $this->total_base_isc,
            'total_isc' => $this->total_isc,
            'total_base_other_taxes' => $this->total_base_other_taxes,
            'total_other_taxes' => $this->total_other_taxes,
            'total_taxes' => $this->total_taxes,
            'total_value' => $this->total_value,
            'total' => $this->total,
            'total_rounded' => $this->total_rounded,
            'tasadefault'=> $tasa,
            'total_payment' => $this->total_payment,
            'num_cuota'     => $this->num_cuota,
            'type_payment'  => $this->type_payment,
            'amount'        => $this->amount,
            'operation_type_id' => $this->operation_type_id,
            'date_of_due' => $this->date_of_due,
            'items' => $this->items,
            'payments' => self::getTransformPayments($this->payments),
            'boxes' => self::getTransformBoxes($this->boxes),
            'charges' => $this->charges,
            'discounts' => $this->discounts,
            'attributes' => $this->attributes,
            'guides' => $this->guides,
            'additional_information' => $this->additional_information,
            'month'  => $this->month,
            'advances' => $this->advances,
            'total_advances' => $this->total_advances,
            'quantity_period' => $this->quantity_period,
            'type_period' => $this->type_period,
            'actions' => $this->actions,
            'observation' =>$this->observation,
            'afectar_caja' =>$afectar_caja,
            'method_pay' =>'Efectivo',
        ];
    }

    // id: null,
    // document_id: null,
    // date_of_payment: moment().format("YYYY-MM-DD"),
    // method: "Efectivo",
    // reference: null,
    // cash_id,
    // amount: 0
    public static function getTransformBoxes($boxes){
        return $boxes->transform(function($row, $key){
                return [
                    'id' => $row->id,
                    'document_id' => $row->sale_note_id,
                    'date_of_payment' => Carbon::parse($row->date)->format('Y-m-d'),
                    'method' => $row->method,
                    'reference' => $row->reference,
                    'cash_id' => $row->cash_id,
                    'amount' => $row->amount,
        
                ];
        });
    }
    public static function getTransformPayments($payments){

        return $payments->transform(function($row, $key){
            return [
                'id' => $row->id,
                'sale_note_id' => $row->sale_note_id,
                'date_of_payment' => $row->date_of_payment->format('Y-m-d'),
                'payment_method_type_id' => $row->payment_method_type_id,
                'has_card' => $row->has_card,
                'card_brand_id' => $row->card_brand_id,
                'reference' => $row->reference,
                'payment' => $row->payment,
                'payment_method_type' => $row->payment_method_type,
                'payment_destination_id' => ($row->global_payment) ? ($row->global_payment->type_record == 'cash' ? 'cash':$row->global_payment->destination_id):null,
                'payment_filename' => ($row->payment_file) ? $row->payment_file->filename:null,
            ];
        });

    }
}
