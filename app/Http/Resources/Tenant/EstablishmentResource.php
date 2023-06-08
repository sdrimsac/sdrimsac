<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Establishment;
use Illuminate\Http\Resources\Json\JsonResource;

class EstablishmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        // $establishment = Establishment::where('id', auth()->user()->id)->first();
        return [
            'id' => $this->id,
            'description' => $this->description,
            'country_id' => $this->country_id,
            'department_id' => $this->department_id,
            'province_id' => $this->province_id,
            'district_id' => $this->district_id,
            'address' => $this->address,
            'conf' => $this->conf,
            'logo' => $this->logo,
            'document_logo' => $this->document_logo,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'code' => $this->code,
            'copies' => $this->copies,
            'trade_address' => $this->trade_address,
            'web_address' => $this->web_address,
            'aditional_information' => $this->aditional_information,
            'format_printer' => $this->format_printer,
            'printer' => $this->printer,
            'printer_serve' => $this->printer_serve,
            'direct_printing' => $this->direct_printing,
            'document_default' => $this->document_default,
            'customer_id' => $this->customer_id,
            'has_igv_31556' => $this->has_igv_31556,
            'documents' => $this->documents
        ];
    }
}
