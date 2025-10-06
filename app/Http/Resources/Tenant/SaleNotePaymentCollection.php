<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Receipt;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SaleNotePaymentCollection extends ResourceCollection
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
            $receipt = Receipt::where('sale_note_payment_id', $row->id)->first();

            $external_id = ($receipt == null) ? "" : url('') . "/receipt/print/{$receipt->external_id}";
            $user_app = auth()->user();
            $configuration = Configuration::first();
            $can_extorned = $user_app->can_accept_credit_sale_note || $configuration->extorned_analist;

            $establishment = Establishment::first();
            if ($establishment->credit_warehouse) {
                $can_extorned = true;
            } else {
                $can_extorned = false;
            }

            return [
                'id' => $row->id,
                'can_extorned' => $can_extorned,
                'extorned' => (bool) $row->extorned,
                'date_of_payment' => $row->date_of_payment->format('d/m/Y'),
                'payment_method_type_description' => $row->payment_method_type->description,
                'destination_description' => ($row->global_payment) ? $row->global_payment->destination_description : null,
                'method' => $row->method,
                'user_id' => $row->user_id,
                'user_name' => $row->user ? $row->user->name : null,
                'number_method' => $row->number_method,
                'reference' => $row->reference,
                'filename' => ($row->payment_file) ? $row->payment_file->filename : null,
                'payment' => $row->payment,
                'date_time_issue' => $row->date_time_issue ? Carbon::parse($row->date_time_issue)->format('d/m/Y H:i:s') : null,
                'receipt_link' => $external_id,
                'quote_date' => $row->payment_register ? Carbon::parse($row->payment_register->date_payment)->format('d/m/Y') : null,
            ];
        });
    }
}
