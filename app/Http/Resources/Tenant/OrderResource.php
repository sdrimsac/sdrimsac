<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'external_id' => $this->external_id,
            'number_document' => $this->number_document,
            'order_id' => str_pad($this->id, 6, "0", STR_PAD_LEFT),
            'customer' => $this->customer->apellidos_y_nombres_o_razon_social,
            'customer_email' => $this->customer->correo_electronico,
            'customer_telefono' => $this->customer->telefono,
            'customer_direccion' => $this->customer->direccion,
            'customer_number' => $this->customer->numero_documento,
            'items' => $this->items,
            'total' => $this->total,
            'reference_payment' => strtoupper($this->reference_payment),
            'document'=>$this->document,
            'document_external_id' => $this->document_external_id,
            'cpe'=>$this->document,
            'number_document'=>$this->number_document,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'status_order_id' => $this->status_order_id
        ];
    }
}