<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Box;
use App\Models\Tenant\Catalogs\DetractionType;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\DetractionPayment;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Restaurant\Models\Orden;

class DocumentDetractionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {

        return $this->collection->transform(function ($row, $key) {
            $configuration = Configuration::first();
            $detraction = $row->detraction;
            $type =  isset($detraction) ? $detraction->detraction_type_id : null;
            $percentage =  isset($detraction) ? $detraction->percentage : null;
            $amount =  isset($detraction) ? $detraction->amount : null;
            $detraction_type = DetractionType::find($type);
            $detraction_description = isset($detraction_type) ? $detraction_type->description : null;
            $sum_payments = DetractionPayment::where('document_id', $row->id)->sum('payment');
            $pendig_payment = $amount - $sum_payments;
            return [
                'pending_payment' => number_format($pendig_payment, 2, '.', ''),
                'paid' => number_format($sum_payments, 2, '.', ''),
                'id' => $row->id,
                'number_full' => $row->number_full,
                'date_of_issue' => $row->date_of_issue,
                'code' => $type,
                'percentage' => $percentage,
                'amount' => $amount,
                'detraction_description' => $detraction_description,
            ];
        });
    }


    private function getDispatches($row)
    {

        $dispatches = [];

        if (in_array($row->document_type_id, ['01', '03'])) {

            $dispatches = $row->reference_guides->transform(function ($row) {
                return [
                    'description' => $row->number_full,
                ];
            });

            if ($row->dispatch) {
                $dispatches = $dispatches->push([
                    'description' => $row->dispatch->number_full,
                ]);
            }
        }
        return $dispatches;
    }
}
