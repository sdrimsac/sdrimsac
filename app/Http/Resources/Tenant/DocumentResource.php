<?php

namespace App\Http\Resources\Tenant;

use App\CoreFacturalo\Helpers\Storage\StorageDocument;
use App\Http\Controllers\DownloadController;
use App\Models\Tenant\Establishment;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
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


        return [
            'id' => $this->id,
            'external_id' => $this->external_id,
            'afectar_caja' => false,
            'establishment_id' => $this->establishment_id,
            'document_type_id' => $this->document_type_id,
            'format_printer' => $establishment->format_printer,
            'method_pay' => 'Efectivo',
            'printerOn' => false,
            'printer' => $establishment->printer,
            'printer_serve' => $establishment->printer_serve,
            'direct_printing' => (bool)$establishment->direct_printing,
            'group_id' => $this->group_id,
            'number' => $this->document_type->description . " Nº " . $this->number_full,
            'total_rounded' => $this->total_rounded,
            'total_payment' => $this->total_payment,
            'date_of_issue' => $this->date_of_issue,
            'customer_email' => $this->customer->email,
            'download_pdf' => $this->download_external_pdf,
            'print_ticket' => url('') . "/print/document/{$this->external_id}/ticket",
            'ticket_50' => url('') . "/print/document/{$this->external_id}/ticket_50",
            'ticket' => url('') . "/print/document/{$this->external_id}/ticket",
            'print_a4' => url('') . "/print/document/{$this->external_id}/a4",
            'print_a5' => url('') . "/print/document/{$this->external_id}/a5",
            'image_detraction' => ($this->detraction) ? (($this->detraction->image_pay_constancy) ?
                asset('storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'image_detractions' . DIRECTORY_SEPARATOR . $this->detraction->image_pay_constancy) : false) : false,
            'detraction' => $this->detraction,
            'response_message' => $response_message,
            'response_type' => $response_type,
            'customer_telephone' => optional($this->person)->telephone,
            'message_text' => "Su comprobante de pago electrónico {$this->number_full} ha sido generado correctamente, puede revisarlo en el siguiente enlace: " . url('') . "/print/document/{$this->external_id}/a4" . "",
            //      'print_ticket_base64' => $download,
        ];
    }
}
