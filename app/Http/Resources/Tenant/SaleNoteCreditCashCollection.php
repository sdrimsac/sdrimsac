<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Box;
use App\Models\Tenant\Payment;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\SaleNotePayment;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Restaurant\Models\Orden;

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
    
            $configuration = Configuration::first();

            
    

            if ($row->paid == 1) {
                $paid = true;
            } else {
                $paid = false;
            }

            $tax_rate = 0;
    
            $total = $row->total;

    
            $paid = (float)  SaleNotePayment::where('sale_note_id', $row->id)->sum('payment');
            $pending = floatval($total) - floatval($paid);
            if ($row->paid) {
                $pending = 0;
            }


            $boxes = Box::where('sale_note_id', $row->id);
            $total_boxes = floatval($boxes->sum('amount'));
            $boxes = $boxes->get();

    

            $orden = Orden::where('sale_note_id', $row->id)->first();
            
        
            if($total_boxes == floatval($row->total)){

                $pending = 0;
                // $paid = true;
                $row->paid = 1;
                $row->save();
            }
            $table_number = null;
            $orden = $row->orden;
            if ($orden) {
                $table = $orden->mesa;
                if ($table) {
                    $table_number = $table->number;
                }
            }
            return [
                'table_number' => $table_number,
                'credit_cash' => (bool) $row->credit_cash,
                'from_consignment' => (bool) $row->from_consignment,
                'pending' => $pending,
                'remain' => $pending,
                'advances' => $row->advances,
                'paid_amount' => $total_boxes,
                // 'paid_amount' => $paid,
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
                'paid' => (bool) $row->paid, //$paid,
                'total_paid' => 0,
                'total_pending_paid' => 0,
                'user_name' => ($row->user) ? $row->user->name : '',
                'number_full' => $row->number_full,
                // 'observation' =>$row->$observation,
            ];
        });
    }
}
