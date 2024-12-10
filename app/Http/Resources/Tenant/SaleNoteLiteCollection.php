<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Box;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SaleNoteLiteCollection extends ResourceCollection
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








            // Inicializar variables con conversión de tipos una sola vez
            $total = (float) $row->total;
            $boxes = Box::where('sale_note_id', $row->id)->get();
            $total_boxes = (float) $boxes->sum('amount');

            // Calcular pending con una lógica simplificada
            if ($row->paid) {
                $pending = 0;
            } elseif ($row->advances > 0) {
                $pending = $total - $row->advances;
            } else {
                $pending = $total - $total_boxes;
            }

            // Actualizar estado de pago si corresponde
            if ($total_boxes == $total) {
                $pending = 0;
                $row->paid = 1;
                $row->save();
            }

            return [
                'credit_cash' => (bool) $row->credit_cash,
                'from_consignment' => (bool) $row->from_consignment,
                'pending' => $pending,
                'remain' => $pending,
                'advances' => $row->advances,
                'paid_amount' => $total_boxes,
                // 'paid_amount' => $paid,
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
                'advances' => $row->advances,
                'documents' => $row->documents->transform(function ($row) {
                    return [
                        'id' => $row->id,
                        'number_full' => $row->number_full,
                    ];
                }),
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
                'number_full' => $row->number_full,
                'btn_schedule' => false,
                'variation' => $row->variationDocument,
            ];
        });
    }
}
