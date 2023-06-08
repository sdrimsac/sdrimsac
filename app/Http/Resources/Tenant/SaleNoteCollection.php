<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Box;
use App\Models\Tenant\Payment;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\SaleNotePayment;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SaleNoteCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->transform(function ($row, $key) {
            // $payment=Payment::where('sale_note_id',$row->id);
            // $schedule=$payment->count();
            //  $payment_tasa=$payment->first();
            $configuration = Configuration::first();

            // if($schedule>0){
            //     $btn_schedule=true;
            //     $interes=($row->total-$row->advances)*($payment_tasa->tasa/100);

            // }else{
            //     $btn_schedule=false;
            //     $interes=0;
            // }
            // $total_paid =  number_format($row->payments->sum('payment'), 2, ".", "");
            // if($row->total_payment!=null){
            //     $total_pending_paid = number_format($row->total_payment - $total_paid, 2, ".", "");
            // }else{
            //     $total_pending_paid = number_format($row->total - $total_paid, 2, ".", "");

            // }

            $btn_generate = (count($row->documents) > 0) ? false : true;
            $btn_payments = (count($row->documents) > 0) ? false : true;

            $is_credit = (count($row->credit_payments) > 0);
            if ($row->paid == 1) {
                $paid = true;
            } else {
                $paid = false;
            }

            $payments_credit = Payment::where('sale_note_id', $row->id)->first();
            $tax_rate = 0;
            if ($payments_credit) {
                $tax_rate = $payments_credit->tasa;
            }
            $total = $row->total;

            $payments = Payment::where('sale_note_id', $row->id)->sum('amount');
            if ($payments > 0) {
                $total = $payments;
            }
            $paid = (float)  SaleNotePayment::where('sale_note_id', $row->id)->sum('payment');
            $pending = floatval($total) - floatval($paid);
            if ($row->paid) {
                $pending = 0;
            }


            $boxes = Box::where('sale_note_id', $row->id)->get();
            $dispatches = $row->dispatches->transform(function ($dispatch) {
                return [
                    'id' => $dispatch->id,
                    'number_full' => $dispatch->number_full,
                ];
            });
            return [
                'pending' => $pending,
                'advances' => $row->advances,
                'paid_amount' => $paid,
                'tax_rate' => $tax_rate,
                'is_credit' => $is_credit,
                'dispatches' => $dispatches,
                'boxes' => $boxes,
                'id' => $row->id,
                'document_type_id' => $row->document_type_id,
                'soap_type_id' => $row->soap_type_id,
                'external_id' => $row->external_id,
                'date_of_issue' => $row->date_of_issue->format('d-m-Y'),
                //set time_of_issue, this is a string, then, explode by ":" and join de 2 first parts with ":"
                'time_of_issue' => implode(':', array_slice(explode(':', $row->time_of_issue), 0, 2)),

                'identifier' => $row->identifier,
                'full_number' => $row->series . '-' . $row->number,
                'customer_name' => $row->customer->name,
                'customer_number' => $row->customer->number,
                'currency_type_id' => $row->currency_type_id,
                'interes'          =>  0,
                'total_exportation' => number_format($row->total_exportation, 2),
                'total_free' => number_format($row->total_free, 2),
                'total_unaffected' => number_format($row->total_unaffected, 2),
                'total_exonerated' => number_format($row->total_exonerated, 2),
                'total_taxed' => number_format($row->total_taxed, 2),
                'total_igv' => number_format($row->total_igv, 2),
                // 'total' => $row->total,
                'total' => $total,
                'total_rounded' => $row->total_rounded,
                'total_payment' => $row->total_payment,
                'state_type_id' => $row->state_type_id,
                'state_type_description' => $row->state_type->description,
                'btn_show_contract' => ($configuration->show_contract == 1) ? true : false,
                'advances' => $row->advances,
                'documents' => $row->documents->transform(function ($row) {
                    return [
                        'id' => $row->id,
                        'number_full' => $row->number_full,
                    ];
                }),
                'btn_generate' => $btn_generate,
                'btn_payments' => $btn_payments,
                'changed' => (bool) $row->changed,
                'enabled_concurrency' => (bool) $row->enabled_concurrency,
                'quantity_period' => $row->quantity_period,
                'type_period' => $row->type_period,
                'apply_concurrency' => (bool) $row->apply_concurrency,
                'created_at' => $row->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $row->updated_at->format('Y-m-d H:i:s'),
                'paid' => (bool) $row->paid, //$paid,
                'license_plate' => $row->license_plate,
                'total_paid' => 0,
                'total_pending_paid' => 0,
                'user_name' => ($row->user) ? $row->user->name : '',
                'quotation_number_full' => ($row->quotation) ? $row->quotation->number_full : '',
                'sale_opportunity_number_full' => isset($row->quotation->sale_opportunity) ? $row->quotation->sale_opportunity->number_full : '',
                'number_full' => $row->number_full,
                'btn_schedule' => false,
                'variation' => $row->variationDocument,
                // 'observation' =>$row->$observation,
            ];
        });
    }
}
