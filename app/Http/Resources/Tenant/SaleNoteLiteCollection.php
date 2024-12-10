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
            $total_boxes = (float) $row->boxes->sum('amount');

            // Calcular pending con una lógica simplificada
            if ($row->paid) {
                $pending = 0;
            } elseif ($row->advances > 0) {
                $pending = $total - $row->advances;
            } else {
                $pending = $total - $total_boxes;
            }

            // Actualizar estado de pago si corresponde
            if ($total_boxes >= $total) {
                $pending = 0;
                $row->paid = 1;
                $row->save();
            }

            return [
                'credit_cash' => (bool) $row->credit_cash,
                'pending' => $pending,
                'remain' => $pending,
                'advances' => $row->advances,
                'paid_amount' => $total_boxes,
                'id' => $row->id,
                'document_type_id' => $row->document_type_id,
                'soap_type_id' => $row->soap_type_id,
                'external_id' => $row->external_id,
                'date_of_issue' => $row->date_of_issue->format('d-m-Y'),
                'time_of_issue' => implode(':', array_slice(explode(':', $row->time_of_issue), 0, 2)),

                'identifier' => $row->identifier,
                'full_number' => $row->series . '-' . $row->number,
                'customer_name' => $row->customer->name,
                'customer_number' => $row->customer->number,
                'currency_type_id' => $row->currency_type_id,
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
        
                'created_at' => $row->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $row->updated_at->format('Y-m-d H:i:s'),
                'total_paid' => 0,
                'total_pending_paid' => 0,
                'user_name' => ($row->user) ? $row->user->name : '',
                'number_full' => $row->number_full,
            ];
        });
    }
}
