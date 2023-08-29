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
use Carbon\Carbon;
use Modules\Report\Exports\ReportCreditExport;
use Modules\Report\Http\Resources\ReportCreditCollection;

class ReportCreditController extends Controller
{
    use ReportTrait;


    public function filter()
    {


        $establishments = Establishment::all()->transform(function ($row) {
            return [
                'id' => $row->id,
                'name' => $row->description
            ];
        });
        $sellers = $this->getSellers();
        $persons = $this->getPersons('customers');

        return compact('establishments', 'sellers', 'persons');
    }


    public function index()
    {

        return view('report::credits.index');
    }

    public function records(Request $request)
    {   
        $paid = $request->paid;

        $period = $this->getDatesOfPeriod($request);
        $person_id = $request->person_id;
        $params = (object)[
            'date_start' => $period['d_start'],
            'date_end' => $period['d_end'],
        ];

        $records = SaleNote::whereHas('creditPayments')
            ->whereBetween('date_of_issue', [$params->date_start, $params->date_end]);

        if ($person_id) {
            $records = $records->where('customer_id', $person_id);
        }
        if($paid != null){
            $records = $records->where('paid', $paid);
        }

        $records->orderBy('created_at', 'desc');

        return new ReportCreditCollection($records->paginate(config('tenant.items_per_page')));
    }



    public function pdf(Request $request)
    {
        $period = $this->getDatesOfPeriod($request);
        $person_id = $request->person_id;
        $params = (object)[
            'date_start' => $period['d_start'],
            'date_end' => $period['d_end'],
        ];
        $company = Company::first();
        $establishment = Establishment::first();
        $records = SaleNote::whereHas('creditPayments')
            ->whereBetween('date_of_issue', [$params->date_start, $params->date_end]);
        if ($person_id) {
            $records = $records->where('customer_id', $person_id);
        }
        $all_records = [];
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




    public function excel(Request $request)
    {

        $period = $this->getDatesOfPeriod($request);
        $person_id = $request->person_id;
        $params = (object)[
            'date_start' => $period['d_start'],
            'date_end' => $period['d_end'],
        ];
        $company = Company::first();
        $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;
        $records = SaleNote::whereHas('creditPayments')
            ->whereBetween('date_of_issue', [$params->date_start, $params->date_end]);
        if ($person_id) {
            $records = $records->where('customer_id', $person_id);
        }
        $all_records = [];
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
