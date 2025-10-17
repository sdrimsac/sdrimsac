<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Box;
use App\Models\Tenant\Payment;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\SaleNotePayment;
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
            // Sum only incoming box entries (payments). When a payment is extorned an expense box is created
            // so summing all boxes will double-count the amount. Filter by 'type' == 1 or incomes == 1.
            $total_boxes = (float) $row->boxes->filter(function($b) {
                return (isset($b->type) && intval($b->type) === 1) || (isset($b->incomes) && intval($b->incomes) === 1);
            })->sum('amount');

            // Compute effective payments directly (only non-extorned)
            $payments_effective = (float) SaleNotePayment::where('sale_note_id', $row->id)
                ->where('extorned', 0)
                ->sum('payment');

            // Calcular el monto pagado considerando cajas (boxes), pagos efectivos y anticipos
            $paid_amount = $total_boxes + $payments_effective + (float) $row->advances;

            // Calcular pending y asegurarnos que no sea negativo
            $pending = $row->paid ? 0 : max(0, $total - $paid_amount);

            // Actualizar estado de pago si corresponde (cuando lo pagado cubre el total)
            if ($paid_amount >= $total && !$row->paid) {
                $pending = 0;
                $row->paid = 1;
                $row->save();
            }

            return [
                'credit_cash' => (bool) $row->credit_cash,
                'pending' => $pending,
                'remain' => $pending,
                'advances' => $row->advances,
                'paid_amount' => $paid_amount,
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
                   