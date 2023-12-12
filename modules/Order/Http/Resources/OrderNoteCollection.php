<?php

namespace Modules\Order\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderNoteCollection extends ResourceCollection
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
         
            $btn_generate = (count($row->documents) > 0 || count($row->sale_notes) > 0)?false:true;
            //$document_type_id=strlen();
            //dd($row->documents[0]->document_type_id);
            return [
                'id' => $row->id,
                'soap_type_id' => $row->soap_type_id,
                'external_id' => $row->external_id,
                'date_of_issue' => $row->date_of_issue->format('d-m-Y'),
                'date_of_due' => ($row->date_of_due) ? $row->date_of_due : null,
                'delivery_date' => ($row->delivery_date) ? $row->delivery_date : null,
                'identifier' => $row->identifier,
                'user_id' => $row->user->id,
                'user_name' => $row->user->name,
                'customer_id' => $row->customer_id,
                'customer_name' => $row->customer->name,
                'customer_number' => $row->customer->number,
                'currency_type_id' => $row->currency_type_id,
                'total_exportation' => number_format($row->total_exportation,2),
                'customers' =>$row->customer,
                'items' => $row->items,
                'total_unaffected' => number_format($row->total_unaffected,2),
                'total_exonerated' => number_format($row->total_exonerated,2),
                'total_taxed' => number_format($row->total_taxed,2),
                'total_igv' => number_format($row->total_igv,2),
                'total' => number_format($row->total,2),
                'state_type_id' => $row->state_type_id,
                'state_type_description' => $row->state_type->description,
                'document' => $row->document,
                'document_number' => $row->document_number,
                'documents' => $row->documents->transform(function($row) {
                    return [
                        'number_full' => $row->number_full,
                        'document_id' => $row->id,
                    ];
                }),
                'sale_notes' => $row->sale_notes->transform(function($row) {
                    return [
                        'identifier' => $row->identifier,
                        'id' => $row->id,
                    ];
                }),
                'btn_generate' => $btn_generate,
                'created_at' => $row->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $row->updated_at->format('Y-m-d H:i:s'),
            ];
        });
    }

}
