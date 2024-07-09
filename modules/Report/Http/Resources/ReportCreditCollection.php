<?php

namespace Modules\Report\Http\Resources;

use App\Models\Tenant\Payment;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\SaleNotePayment;
use App\Models\Tenant\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReportCreditCollection extends ResourceCollection
{


    public function toArray($request)
    {


        return $this->collection->transform(function ($row, $key) {
            $advances  = $row->advances;
            $paid = $row->paid;
            $payment = Payment::where('sale_note_id', $row->id);
            $payment_to_due = Payment::where('sale_note_id', $row->id)
                ->where('paid', 0)
                ->first();
            if ($payment_to_due) {
                $paid = false;
                $row->paid = false;
                $row->save();
            }
            $payment_not_paid = $payment->where('paid', 0)
                ->where('date_payment', '<=', Carbon::now()->startOfDay())
                ->orderBy('date_payment', 'desc');
            $last_payment =  Payment::where('sale_note_id', $row->id)
                ->where('paid', 0)
                ->orderBy('date_payment', 'asc')
                ->first();
            $dues = !$paid ? $payment_not_paid->count() : 0;
            $date_of_due = ($last_payment) ? $last_payment->date_payment : null;
            $quote_payment = ($last_payment) ? $last_payment->amount : 0;
            $differenc_days = 0;
            if ($date_of_due && $dues > 0 && !$paid) {
                if (is_object($date_of_due)) {
                    $date_of_due = $date_of_due->format('Y-m-d');
                }
                $differenc_days = Carbon::parse($date_of_due)->diffInDays(Carbon::now()->startOfDay(), false);
            }

            $customer = $row->customer;
            $amount_due = 0;
            $payments_records = SaleNotePayment::where('sale_note_id', $row->id)->sum('payment');
            if ($last_payment == null) {
                $last_paid =  Payment::where('sale_note_id', $row->id)
                    ->where('paid', 1)
                    ->orderBy('date_payment', 'asc')
                    ->first();
                // $amount_due = $last_paid->amount;
            }
            // $amount_due -= $advances + $payments_records;
            $payment = Payment::where('sale_note_id', $row->id)
                ->where('paid', 0);
            $penalties_payed = Payment::where('sale_note_id', $row->id)
                ->where('paid', 1)
                ->sum('penalty_amount');
            $int = 0;
            if ($payment->count() > 0) {
                $payment_first = $payment->first();

                $int = ($row->total - $advances) * ($payment_first->tasa / 100);
            }
            if ($row->paid == true) {
                $to_due = 0;
            } else {
                $to_due =  floatval($row->total + $row->total_discount - $advances + $int)  - (floatval($payments_records - $penalties_payed));
            }
            $show_formats = true;
            // $user_id = auth()->user()->id;
            $user = User::find(auth()->user()->id);
            $is_analist = $user->isWorkerType('analista');
            if ($is_analist && $row->status != "A") {
                $show_formats = false;
            }
            $can_edit = SaleNotePayment::where('sale_note_id', $row->id)->count() > 0 ? false : true;
            if ($row->status == "R") {
                $can_edit = false;
            }
            $user_name = $row->user->name;
            $schedules = [];
            $num_quotes = $row->is_cash == false ? 32 : 26;
            $quotes = $payment->count();
            $quotes = $quotes / $num_quotes;
            $quotes = ceil($quotes);
            if ($quotes == 0) {
                $quotes = 1;
            }
            //iterar por quotes

            for ($i = 0; $i < $quotes; $i++) {
                if ($row->is_cash) {

                    $schedules[] = url('/sale-notes/cash_schedule/' . $row->id . '/' . ($i + 1));
                } else {
                    $schedules[] = url('/sale-notes/hogar_schedule/' . $row->id . '/' . ($i + 1));
                }
            }
            $observation = $row->observation;
            if ($row->state_type_id == '11' || $row->state === 'O') {
                $observation_credit = $row->sale_note_credit->reason_to_anulate_credit;
                $observation .= " " . $observation_credit;
            }
            return [
                'quote_payment' => $quote_payment,
                'state_type_id' => $row->state_type_id,
                'quotes' => $quotes,
                'schedules' => $schedules,
                'is_cash' => (bool) $row->is_cash,
                'is_product' => (bool) $row->is_product,
                'user_name' => $user_name,
                'show_formats' => $show_formats,
                'id' => $row->id,
                'status' => $row->status,
                'can_edit' => $can_edit,
                'date_of_issue' => $row->date_of_issue->format('Y-m-d'),
                'customer' => ["name" => $customer->name, "number" => $customer->number],
                'number' => $row->number_full,
                'dues' => $dues,
                'total' => $row->total   - $advances + $int,
                'advances' => $advances,
                'payment' => $payments_records,
                'type_payment' => $row->type_payment,
                'date_of_due' => $date_of_due,
                'canceled' => (bool) $row->paid,
                'penalty' => $row->status ==  'A' && !$paid ? $row->getPenalties() : 0,
                // 'amount_due' => number_format($amount_due, 2, ".", ""),
                'amount_due' => number_format($to_due, 2, ".", ""),
                'differenc_days' => $differenc_days,
                'is_credit' => true,
                'observation' => $observation,
            ];
        });
    }
}
