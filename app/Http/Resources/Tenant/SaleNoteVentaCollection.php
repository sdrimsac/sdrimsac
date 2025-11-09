<?php

namespace App\Http\Resources\Tenant;

use Carbon\Carbon;
use App\Models\Tenant\Box;
use App\Models\Tenant\Payment;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\SaleNotePayment;
use App\Models\Tenant\Establishment;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Restaurant\Models\Orden;

class SaleNoteVentaCollection extends ResourceCollection
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
            $establishment_description = Establishment::find($row->establishment_id)->description;
            
            return [
                /* 'number_full' => $row->number_full, */
                'establishment_description' => $establishment_description,
                'document_type_id'=>$row->document_type_id,
                'date_of_issue' => $row->date_of_issue->format('d-m-Y'),
                'time_of_issue' => implode(':', array_slice(explode(':', $row->time_of_issue), 0, 2)),
                /* 'time_of_issue' => $row->time_of_issue, */
                'number' =>$row->series."-". $row->number,
                'series' => $row->series,
                'alone_number' => $row->number,
                // Agregar descripción del cliente: "documento - nombre"
                'client_description' => ($row->customer) ? ($row->customer->number . ' - ' . $row->customer->name) : null,
                'client_number' => ($row->customer) ? $row->customer->number : null,
                'client_name' => ($row->customer) ? $row->customer->name : null,
                'items' => $row->items->map(function ($item){
                    return [
                        'item_id' => $item->id,
                        'item' => $item->item,
                        'warehouse_id' => $item->warehouse_id,
                        'unit_value' => $item->unit_value,
                        'quantity' => $item->quantity,
                        'total' => $item->total,
                    ];
                })
            ];
        });
    }
}
