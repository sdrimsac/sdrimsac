<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Box;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\DocumentPayment;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DocumentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {

        return $this->collection->transform(function ($row, $key) {
            $configuration = Configuration::first();
            $has_xml = true;
            $has_pdf = true;
            $has_cdr = false;
            $btn_note = false;
            $btn_guide = true;
            $btn_resend = false;
            $btn_voided = false;
            $btn_consult_cdr = false;
            $btn_delete_doc_type_03 = true;
            $btn_constancy_detraction = false;

            $affected_document = null;
            if ($row->state_type_id === '01') {
                $btn_resend = true;
            } else {
                $btn_resend = false;
            }
            if ($row->group_id === '01') {


                if ($row->state_type_id === '05') {
                    $has_cdr = true;
                    $btn_note = true;

                    $btn_voided = true;
                    $btn_consult_cdr = true;
                }

                if (in_array($row->document_type_id, ['07', '08'])) {
                    $btn_note = false;
                }
            }
            if ($row->group_id === '02') {
                if ($row->state_type_id === '05') {
                    $btn_note = true;
                    $btn_voided = true;
                }

                if (in_array($row->document_type_id, ['07', '08'])) {
                    $btn_note = false;
                }
                if ($row->state_type_id === '01' || $row->state_type_id === '03') {
                    $btn_delete_doc_type_03 = true;
                }

                if ($row->document_type_id === '03' && $configuration->delete_document) {
                }
            }

            if (in_array($row->document_type_id, ['01', '03'])) {
                $btn_constancy_detraction = ($row->detraction) ? true : false;
            }

            $btn_guide = $btn_note;
            if ($btn_guide === false && ($row->state_type_id === '01')) {
                // #750
                $btn_guide = true;
            }
            $btn_recreate_document = $configuration->recreat_document;

            $btn_change_to_registered_status = false;
            if ($row->state_type_id === '01') {
                $btn_change_to_registered_status = config('tenant.change_to_registered_status');
            }

            $total_payments = $row->payments->sum('payment');
            // if ($row->total_rounded==0){
            $balance = number_format(($row->total - $row->total_rounded) - $total_payments, 2, ".", "");

            // }else{
            //    $balance = number_format(($row->tototal_paymenttal) - $total_payments,2, ".", "");

            // }
            $boxes = Box::where('document_id', $row->id);
            $is_credit = $row->payment_condition_id == "02";
            $paid = true;
            $remain = 0;
            if($is_credit){
                $sum = $boxes->sum('amount');
                if($sum < $row->total){
                    $remain = $row->total - $sum;
                    $paid = false;
                }else{
                    $row->canceled();
                }
            }

            $boxes = $boxes->get();
            return [
                'remain' => $remain,
                'paid' => $paid,
                'is_credit' => $row->payment_condition_id == "02",
                'dispatch_id' => $row->dispatch_id,
                'boxes' => $boxes,
                'id' => $row->id,
                'group_id' => $row->group_id,
                'soap_type_id' => $row->soap_type_id,
                'soap_type_description' => $row->soap_type->description,
                'date_of_issue' => $row->date_of_issue,
                'from_consignment' => (bool) $row->from_consignment,
                //    'date_of_due' => (in_array($row->document_type_id, ['01', '03'])) ? $row->invoice->date_of_due->format('Y-m-d') : null,
                'number' => $row->number_full,
                'payment' => $row->payments,
                'customer_name' => $row->customer->name,
                'customer_number' => $row->customer->number,
                'customer_telephone' => $row->customer->telephone,
                'currency_type_id' => $row->currency_type_id,
                'total_exportation' => $row->total_exportation,
                'total_free' => $row->total_free,
                'total_unaffected' => $row->total_unaffected,
                'total_exonerated' => $row->total_exonerated,
                'total_taxed' => $row->total_taxed,
                'total_taxes' => $row->total_taxes,
                'total_igv' => $row->total_igv,
                'total' => $row->total,
                'total_rounded' => $row->total_rounded,
                'total_payment' => $row->total_payment,
                'state_type_id' => $row->state_type_id,
                'state_type_description' => $row->state_type->description,
                'document_type_description' => $row->document_type->description,
                'document_type_id' => $row->document_type->id,
                'has_xml' => $has_xml,
                'has_pdf' => $has_pdf,
                'has_cdr' => $has_cdr,
                'download_xml' => $row->download_external_xml,
                'download_pdf' => $row->download_external_pdf,
                'download_cdr' => $row->download_external_cdr,
                'btn_voided' => $btn_voided,
                'btn_note' => $btn_note,
                'btn_guide' => $btn_guide,
                //                'btn_ticket' => $btn_ticket,
                'dispatches' => $this->getDispatches($row),
                'btn_resend' => $btn_resend,
                'btn_consult_cdr' => $btn_consult_cdr,
                'btn_constancy_detraction' => $btn_constancy_detraction,
                'btn_recreate_document' => (bool) $btn_recreate_document,
                'btn_change_to_registered_status' => $btn_change_to_registered_status,
                'btn_delete_doc_type_03' => $btn_delete_doc_type_03,
                'send_server' => (bool) $row->send_server,
                //                'voided' => $voided,
                'affected_document' => $affected_document,
                //                'has_xml_voided' => $has_xml_voided,
                //                'has_cdr_voided' => $has_cdr_voided,
                //                'download_xml_voided' => $download_xml_voided,
                //                'download_cdr_voided' => $download_cdr_voided,
                'shipping_status' => json_decode($row->shipping_status),
                'sunat_shipping_status' => json_decode($row->sunat_shipping_status),
                'query_status' => json_decode($row->query_status),
                //      'created_at' => $row->created_at->format('Y-m-d H:i:s'),
                //       'updated_at' => $row->updated_at->format('Y-m-d H:i:s'),
                'user_name' => ($row->user) ? $row->user->name : '',
                'user_email' => ($row->user) ? $row->user->email : '',
                'external_id' => $row->external_id,
                'observation' => $row->observation,

                'balance' => $balance

            ];
        });
    }


    private function getDispatches($row)
    {

        $dispatches = [];

        if (in_array($row->document_type_id, ['01', '03'])) {

            $dispatches = $row->reference_guides->transform(function ($row) {
                return [
                    'description' => $row->number_full,
                ];
            });

            if ($row->dispatch) {
                $dispatches = $dispatches->push([
                    'description' => $row->dispatch->number_full,
                ]);
            }
        }

        return $dispatches;
    }
}
