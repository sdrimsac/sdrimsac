<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Box;
use App\Models\Tenant\Payment;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\SaleNotePayment;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Restaurant\Models\Orden;
use Carbon\Carbon;
use App\Models\Tenant\RegisterMovement;

class SaleNoteMobileCollection extends ResourceCollection
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

            $total = $row->total;

            return [
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
                'btn_show_contract' => ($configuration->show_contract == 1) ? true : false,
                'advances' => $row->advances,
                'documents' => $row->documents->transform(function ($row) {
                    return [
                        'id' => $row->id,
                        'number_full' => $row->number_full,
                    ];
                }),
                'user_name' => ($row->user) ? $row->user->name : '',
                'quotation_number_full' => ($row->quotation) ? $row->quotation->number_full : '',
                'sale_opportunity_number_full' => isset($row->quotation->sale_opportunity) ? $row->quotation->sale_opportunity->number_full : '',
                'number_full' => $row->number_full,
            ];
        });
    }
}
