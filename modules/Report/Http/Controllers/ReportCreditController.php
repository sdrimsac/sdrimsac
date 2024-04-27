<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use Modules\Report\Exports\DocumentExport;
use Illuminate\Http\Request;
use Modules\Report\Traits\ReportTrait;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\User;
use App\Models\Tenant\Document;
use App\Models\Tenant\Company;
use App\Models\Tenant\Payment;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\SaleNotePayment;
use Carbon\Carbon;
use Modules\Report\Exports\ReportCreditExport;
use Modules\Report\Http\Resources\ReportCreditCollection;

class ReportCreditController extends Controller
{
    use ReportTrait;


    public function filter()
    {

        $users = User::whereType('seller')
            ->where('active', true)
            ->get()
            ->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'name' => $row->name
                ];
            });
        $establishments = Establishment::all()->transform(function ($row) {
            return [
                'id' => $row->id,
                'name' => $row->description
            ];
        });
        $sellers = $this->getSellers();
        $persons = $this->getPersons('customers');

        return compact('establishments', 'sellers', 'persons', 'users');
    }


    public function index()
    {

        return view('report::credits.index');
    }

    public function records(Request $request)
    {
        $paid = $request->paid;
        $status = $request->status;
        $period = $this->getDatesOfPeriod($request);
        $person_id = $request->person_id;
        $user_id = $request->user_id;
        $type = $request->type;
        $type_payment = $request->type_payment;
        $params = (object)[
            'date_start' => $period['d_start'],
            'date_end' => $period['d_end'],
        ];
        if ($status == "R") {
            $records = SaleNote::where('status', 'R');
        } else {
            $records = SaleNote::whereHas('creditPayments');
        }
        if ($params->date_start && $params->date_end) {
            $records =
                $records->whereBetween('date_of_issue', [$params->date_start, $params->date_end]);
        }

        if ($status && $status != "R") {
            $records = $records->where('status', $status);
        }

        if ($person_id) {
            $records = $records->where('customer_id', $person_id);
        }
        if ($paid != null) {
            $records = $records->where('paid', $paid);
        }
        if ($type != null) {
            if ($type == 'is_product') {
                $records = $records->where('is_product', true);
            }
            if ($type == 'is_cash') {
                $records = $records->where('is_cash', true);
            }
        }
        if ($type_payment != null) {
            $records = $records->where('type_payment', $type_payment);
        }


        if ($user_id) {
            $records = $records->where('user_id', $user_id);
        }
        $records->orderBy('date_of_issue', 'desc');

        return new ReportCreditCollection($records->paginate(config('tenant.items_per_page')));
    }



    public function pdf(Request $request)
    {
        $paid = $request->paid;
        $status = $request->status;
        $period = $this->getDatesOfPeriod($request);
        $person_id = $request->person_id;
        $user_id = $request->user_id;
        $type = $request->type;
        $type_payment = $request->type_payment;
        $params = (object)[
            'date_start' => $period['d_start'],
            'date_end' => $period['d_end'],
        ];
        $company = Company::first();
        $establishment = Establishment::first();
        // $records = SaleNote::whereHas('creditPayments')
        //     ->whereBetween('date_of_issue', [$params->date_start, $params->date_end]);
        // if ($person_id) {
        //     $records = $records->where('customer_id', $person_id);
        // }
        $all_records = [];
        if ($status == "R") {
            $records = SaleNote::where('status', 'R');
        } else {
            $records = SaleNote::whereHas('creditPayments');
        }
        if ($params->date_start && $params->date_end) {
            $records =
                $records->whereBetween('date_of_issue', [$params->date_start, $params->date_end]);
        }

        if ($status && $status != "R") {
            $records = $records->where('status', $status);
        }

        if ($person_id) {
            $records = $records->where('customer_id', $person_id);
        }
        if ($paid != null) {
            $records = $records->where('paid', $paid);
        }
        if ($type != null) {
            if ($type == 'is_product') {
                $records = $records->where('is_product', true);
            }
            if ($type == 'is_cash') {
                $records = $records->where('is_cash', true);
            }
        }
        if ($type_payment != null) {
            $records = $records->where('type_payment', $type_payment);
        }


        if ($user_id) {
            $records = $records->where('user_id', $user_id);
        }
        $records->orderBy('created_at', 'desc')->chunk(50, function ($rows) use (&$all_records) {

            foreach ($rows as $row) {
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
                $amount_due = 0;
                if ($last_payment == null) {
                    $last_paid =  Payment::where('sale_note_id', $row->id)
                        ->where('paid', 1)
                        ->orderBy('date_payment', 'asc')
                        ->first();
                    $amount_due = $last_paid->amount;
                } else {
                    $amount_due = $last_payment->amount;
                }
                $dues = $payment_not_paid->count();
                $customer = $row->customer;
                $all_records[] = [
                    'id' => $row->id,
                    'date_of_issue' => $row->date_of_issue->format('Y-m-d'),
                    'customer' => ["name" => $customer->name, "number" => $customer->number],
                    'number' => $row->number_full,
                    'dues' => $dues,
                    'date_of_due' => $date_of_due,
                    'is_cash' => $row->is_cash,
                    'is_product' => $row->is_product,
                    // 'amount_due' => number_format($amount_due, 2, ".", ""),
                    'amount_due' => number_format($amount_due, 2, ".", ""),
                    'differenc_days' => $differenc_days,
                ];
            }
        });
        $records = $all_records;

        //sort records by key dues(int) of each element
        usort($records, function ($a, $b) {
            return $b['dues'] <=> $a['dues'];
        });

        $pdf = PDF::loadView('report::credits.report_pdf', compact("records", "company", "establishment"));

        $filename = 'Reporte_Crédito_' . date('YmdHis');

        return $pdf->download($filename . '.pdf');
    }

    public function excel_accept(Request $request)
    {

        $period = $this->getDatesOfPeriod($request);
        $paid = $request->paid;
        $person_id = $request->person_id;
        $user_id = $request->user_id;
        $type = $request->type;
        $type_payment = $request->type_payment;
        $params = (object)[
            'date_start' => $period['d_start'],
            'date_end' => $period['d_end'],
        ];
        $company = Company::first();
        $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;
        // $records = SaleNote::whereHas('creditPayments')
        //     ->whereBetween('date_of_issue', [$params->date_start, $params->date_end]);
        // if ($person_id) {
        //     $records = $records->where('customer_id', $person_id);
        // }
        $all_records = [];

        $records = SaleNote::whereHas('creditPayments')
        ->where('paid', true);
        if ($params->date_start && $params->date_end) {
            $records =
                $records->whereBetween('date_of_issue', [$params->date_start, $params->date_end]);
        }


        if ($person_id) {
            $records = $records->where('customer_id', $person_id);
        }
        if ($paid != null) {
            $records = $records->where('paid', $paid);
        }
        if ($type != null) {
            if ($type == 'is_product') {
                $records = $records->where('is_product', true);
            }
            if ($type == 'is_cash') {
                $records = $records->where('is_cash', true);
            }
        }
        if ($type_payment != null) {
            $records = $records->where('type_payment', $type_payment);
        }


        if ($user_id) {
            $records = $records->where('user_id', $user_id);
        }
        $records->orderBy('created_at', 'desc')->chunk(50, function ($rows) use (&$all_records) {

            foreach ($rows as $row) {
                $payment = Payment::where('sale_note_id', $row->id);
                $total_penalties = $payment->sum('penalty_amount');

                $count_payments = $payment->count();
                $payment_not_paid = $payment->where('paid', 0)
                    ->where('date_payment', '<=', Carbon::now()->startOfDay())
                    ->orderBy('date_payment', 'desc');
                $last_payment =  Payment::where('sale_note_id', $row->id)
                    ->where('paid', 0)
                    ->orderBy('date_payment', 'asc')
                    ->first();
                $tasa = Payment::where('sale_note_id', $row->id)->first()->tasa;
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
                if ($last_payment == null) {
                    $last_paid =  Payment::where('sale_note_id', $row->id)
                        ->where('paid', 1)
                        ->orderBy('date_payment', 'asc')
                        ->first();
                    $amount_due = $last_paid->amount;
                } else {
                    $amount_due = $last_payment->amount;
                }
                $total_paid = SaleNotePayment::where('sale_note_id', $row->id)->sum('payment');
                $all_records[] = [
                    'total_paid' => $total_paid,
                    'id' => $row->id,
                    'tasa' => $tasa,
                    'date_of_issue' => $row->date_of_issue->format('Y-m-d'),
                    'customer' => ["name" => $customer->name, "number" => $customer->number],
                    'number' => $row->number_full,
                    'r_dias' => $count_payments,
                    'type_payment' => $row->type_payment,
                    'month' => $row->month,
                    'dues' => $dues,
                    'total' => $row->total,
                    'date_of_due' => $date_of_due,
                    'is_cash' => $row->is_cash,
                    'is_product' => $row->is_product,
                    // 'amount_due' => number_format($amount_due, 2, ".", ""),
                    'amount_due' => number_format($amount_due, 2, ".", ""),
                    'differenc_days' => $differenc_days,
                    'difference_payment' => $total_paid-$row->total,
                    'penalties' => $total_penalties,
                ];
            }
        });
        $records = $all_records;

        //sort records by key dues(int) of each element
        usort($records, function ($a, $b) {
            return $b['dues'] <=> $a['dues'];
        });

        return (new ReportCreditExport)
            ->records($records)
            ->company($company)
            ->viewR('report::credits.report_excel_accept')
            ->establishment($establishment)
            ->download('Reporte_Crédito_' . Carbon::now() . '.xlsx');
    }


    public function excel(Request $request)
    {

        $period = $this->getDatesOfPeriod($request);
        $paid = $request->paid;
        $status = $request->status;
        $period = $this->getDatesOfPeriod($request);
        $person_id = $request->person_id;
        $user_id = $request->user_id;
        $type = $request->type;
        $type_payment = $request->type_payment;
        $params = (object)[
            'date_start' => $period['d_start'],
            'date_end' => $period['d_end'],
        ];
        $company = Company::first();
        $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;
        // $records = SaleNote::whereHas('creditPayments')
        //     ->whereBetween('date_of_issue', [$params->date_start, $params->date_end]);
        // if ($person_id) {
        //     $records = $records->where('customer_id', $person_id);
        // }
        $all_records = [];
        if ($status == "R") {
            $records = SaleNote::where('status', 'R');
        } else {
            $records = SaleNote::whereHas('creditPayments');
        }
        if ($params->date_start && $params->date_end) {
            $records =
                $records->whereBetween('date_of_issue', [$params->date_start, $params->date_end]);
        }

        if ($status && $status != "R") {
            $records = $records->where('status', $status);
        }

        if ($person_id) {
            $records = $records->where('customer_id', $person_id);
        }
        if ($paid != null) {
            $records = $records->where('paid', $paid);
        }
        if ($type != null) {
            if ($type == 'is_product') {
                $records = $records->where('is_product', true);
            }
            if ($type == 'is_cash') {
                $records = $records->where('is_cash', true);
            }
        }
        if ($type_payment != null) {
            $records = $records->where('type_payment', $type_payment);
        }


        if ($user_id) {
            $records = $records->where('user_id', $user_id);
        }
        $records->orderBy('created_at', 'desc')->chunk(50, function ($rows) use (&$all_records) {

            foreach ($rows as $row) {
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
                if ($last_payment == null) {
                    $last_paid =  Payment::where('sale_note_id', $row->id)
                        ->where('paid', 1)
                        ->orderBy('date_payment', 'asc')
                        ->first();
                    $amount_due = $last_paid->amount;
                } else {
                    $amount_due = $last_payment->amount;
                }
                $all_records[] = [
                    'id' => $row->id,
                    'date_of_issue' => $row->date_of_issue->format('Y-m-d'),
                    'customer' => ["name" => $customer->name, "number" => $customer->number],
                    'number' => $row->number_full,
                    'dues' => $dues,
                    'date_of_due' => $date_of_due,
                    'is_cash' => $row->is_cash,
                    'is_product' => $row->is_product,
                    // 'amount_due' => number_format($amount_due, 2, ".", ""),
                    'amount_due' => number_format($amount_due, 2, ".", ""),
                    'differenc_days' => $differenc_days,
                ];
            }
        });
        $records = $all_records;

        //sort records by key dues(int) of each element
        usort($records, function ($a, $b) {
            return $b['dues'] <=> $a['dues'];
        });

        return (new ReportCreditExport)
            ->records($records)
            ->company($company)
            ->establishment($establishment)
            ->download('Reporte_Crédito_' . Carbon::now() . '.xlsx');
    }
}
