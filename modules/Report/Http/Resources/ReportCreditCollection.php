<?php

namespace Modules\Report\Http\Resources;

use App\Models\Tenant\Payment;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\SaleNotePayment;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReportCreditCollection extends ResourceCollection
{


    public function toArray($request)
    {


        return $this->collection->transform(function ($row, $key) {
            $advances  = $row->advances;
            $payment = Payment::where('sale_note_id', $row->id);
            $payment_not_paid = $payment->where('paid', 0)
                ->where('date_payment', '<=', Carbon::now()->startOfDay())
                ->orderBy('date_payment', 'desc');
            $last_payment =  Payment::where('sale_note_id', $row->id)
                ->where('paid', 0)
                ->orderBy('date_payment', 'asc')
                ->first();
            $dues = $payment_not_paid->count();
            $date_of_due = ($last_payment) ? $last_payment->date_payment : null;
            $differenc_days = 0;
            if ($date_of_due && $dues > 0) {
                if (is_object($date_of_due)) {
                    $date_of_due = $date_of_due->format('Y-m-d');
                }
                $differenc_days = Carbon::parse($date_of_due)->diffInDays(Carbon::now()->startOfDay(), false);
            }

            $dues = $payment_not_paid->count();
            $customer = $row->customer;
            $amount_due = 0;
            $payments_records = SaleNotePayment::where('sale_note_id', $row->id)->sum('payment');
            if ($last_payment == null) {
                $last_paid =  Payment::where('sale_note_id', $row->id)
                    ->where('paid', 1)
                    ->orderBy('date_payment', 'asc')
                    ->first();
                $amount_due = $last_paid->amount;
            } else {
                $amount_due = $last_payment->amount;
            }
            // $amount_due -= $advances + $payments_records;
            $to_due =  floatval($row->total)  -( floatval( $advances) + floatval($payments_records));
            return [
                'id' => $row->id,
                'date_of_issue' => $row->date_of_issue->format('Y-m-d'),
                'customer' => ["name" => $customer->name, "number" => $customer->number],
                'number' => $row->number_full,
                'dues' => $dues,
                'total' => $row->total,
                'advances' => $advances,
                'payment' => $payments_records,
                'date_of_due' => $date_of_due,
                'canceled' => (bool) $row->paid,
                // 'amount_due' => number_format($amount_due, 2, ".", ""),
                'amount_due' => number_format($to_due, 2, ".", ""),
                'differenc_days' => $differenc_days,
                'is_credit' => true,
            ];
        });
    }
}
