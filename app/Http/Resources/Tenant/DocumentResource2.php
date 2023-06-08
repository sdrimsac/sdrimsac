<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Person;
use App\Models\Tenant\Establishment;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\DownloadController;
use App\CoreFacturalo\Helpers\Storage\StorageDocument;
use App\Models\Tenant\Box;

class DocumentResource2  extends JsonResource
{
    use StorageDocument;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        $response_message = null;
        $response_type = null;
        $establishment = Establishment::where('id', $this->establishment_id)->first();
        if ($this->soap_shipping_response) {
            if ($this->soap_shipping_response->sent) {

                $response_message = $this->soap_shipping_response->description;
                $code =  (int) $this->soap_shipping_response->code;

                if ($code === 0) {
                    $response_type = 'success';
                } elseif ($code < 2000) {
                    $response_type = 'error';
                } elseif ($code < 4000) {
                    $response_type = 'error';
                } else {
                    $response_type = 'warning';
                }
            }
        }

        if ($this->has_prepayment == 0) {
            $has_prepayment = false;
        } else {
            $has_prepayment = true;
        }
        $customers_finds = Person::findOrFail($this->customer_id);
        $boxes = Box::where('document_id', $this->id)->get();
        return [
            'boxes' => $boxes,
            'id' => $this->id,
            'type' => "invoice",
            'afectar_caja' => false,
            'printerOn' => false,
            'method_pay' => 'Efectivo',
            'establishment_id' => $this->establishment_id,
            'identity_document_type_id' => "6",
            'document_type_id' => $this->document_type_id,
            'payment_condition_id' => $this->payment_condition_id,
            'series_id' => $this->series_id,
            'series' => $this->series,
            'number' => $this->number,
            'date_of_issue' => $this->date_of_issue,
            'date_of_due' => $this->date_of_due,
            'time_of_issue' => $this->time_of_issue,
            'customer_id' => $this->customer_id,
            'currency_type_id' => $this->currency_type_id,
            'purchase_order' => $this->purchase_order,
            'exchange_rate_sale' =>  floatval($this->exchange_rate_sale),
            'total_prepayment' => floatval($this->total_prepayment),
            'total_charge' => floatval($this->total_charge),
            'total_discount' => floatval($this->total_discount),
            'total_exportation' => floatval($this->total_exportation),
            'total_free' => floatval($this->total_free),
            'total_taxed' => floatval($this->total_taxed),
            'total_unaffected' => floatval($this->total_unaffected),
            'total_exonerated' => floatval($this->total_exonerated),
            'total_igv' => floatval($this->total_igv),
            'total_base_isc' => floatval($this->total_base_isc),
            'total_isc' => floatval($this->total_isc),
            'total_base_other_taxes' => floatval($this->total_base_other_taxes),
            'total_other_taxes' => floatval($this->total_other_taxes),
            'total_plastic_bag_taxes' => floatval($this->total_plastic_bag_taxes),
            'total_taxes' => floatval($this->total_taxes),
            'total_value' => floatval($this->total_value),
            'total' => floatval($this->total),
            'total_rounded' => floatval($this->total_rounded),
            'total_payment' => floatval($this->total_payment),
            'operation_type_id' => $this->operation_type_id,

            'items' => $this->items,
            'charges' => $this->charges,
            'discounts' => $this->discounts,
            //   'attributes'=>$this->attributes,
            'guides' => [
                [
                    "document_type_id" => "09",
                    "number" => null
                ],
                [
                    "document_type_id" => "31",
                    "number" => null
                ]
            ],
            'payments' => $this->payments,
            'prepayments' => $this->prepayments,
            'legends' => $this->legends,
            'detraction' => $this->detraction,
            'additional_information' => $this->additional_information,
            'plate_number' => $this->plate_number,
            'has_prepayment' => $has_prepayment,
            'affectation_type_prepayment' => $this->affectation_type_prepayment,
            'observation' => $this->observation,
            'hotel' => $this->hotel,
            'transport' => $this->transport,
            'customer' => $customers_finds,
            'user_id' => $this->user_id,
            "actions" => [
                "format_pdf" => "a4"
            ],
            'hotel' => [],

            'transport' => [],
            //      'print_ticket_base64' => $download,
        ];
    }
}
