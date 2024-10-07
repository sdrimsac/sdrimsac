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
use App\Models\Tenant\SaleNoteItem;
use App\Models\Tenant\SaleNotePayment;
use Carbon\Carbon;
use Modules\Report\Exports\ReportCreditDailyExport;
use Modules\Report\Exports\ReportCreditExport;
use Modules\Report\Exports\ReportCreditTypeCashExport;
use Modules\Report\Exports\ReportCreditTypeExport;
use Modules\Report\Exports\ReportCreditTypeProductExport;
use Modules\Report\Http\Resources\ReportCreditCollection;
use Modules\Report\Http\Resources\ReportCreditDailyCollection;

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
    public function daily_cash()
    {

        return view('report::credits.daily_cash');
    }
    public function index_cash()
    {

        return view('report::credits.index_cash');
    }

    public function daily_cash_filter()
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
    private function get_daily_cash_records(Request $request, $today = false)
    {
        $date = $request->date;
        $credits = SaleNote::where('state_type_id', '!=', '11')
            ->whereHas(
                'creditPayments',
                function ($query) use ($date, $today) {
                    if ($today) {
                        $query->where('date_payment', '=', $date)
                            ->where('paid', 0);
                    } else {
                        $query->where('date_payment', '<=', $date)
                            ->where('paid', 0);
                    }
                }
            )
            ->with(['customer', 'user', 'sale_note_credit', 'creditPayments']);

        // Cargar relaciones necesarias
        return $credits;
    }
    public function daily_cash_records(Request $request)
    {
        $records = $this->get_daily_cash_records($request);

        return new ReportCreditDailyCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function daily_cash_excel_today(Request $request)
    {

        $records = $this->get_daily_cash_records($request, true)->get()->transform(function ($row) {
            $advances  = $row->advances;
            $paid = $row->paid;
            $sale_note_credit = $row->sale_note_credit;
            $penalty_amount_by_day = $sale_note_credit->penalty_amount_by_day;
            // $payment = Payment::where('sale_note_id', $row->id);
            $today = Carbon::now()->startOfDay();
            $payments = Payment::where('sale_note_id', $row->id)
                ->where('paid', 0)
                ->where('date_payment', '<=', $today)
                ->get()
                ->transform(function ($row_payment, $key) use (&$row, &$paid, $penalty_amount_by_day) {
                    $existing_payments_count = Payment::where('sale_note_id', $row->id)
                        ->where('id', '<=', $row_payment->id)
                        ->count();
                    if ($row->paid == 0) {
                        $paid = false;
                        $row->paid = false;
                    }
                    $diffence_days = 0;
                    if ($row_payment->date_payment) {
                        $diffence_days = Carbon::parse($row_payment->date_payment)->diffInDays(Carbon::now()->startOfDay(), false);
                    }
                    $total = $row_payment->amount + $row_payment->penalty_amount;
                    $total_penalty = $penalty_amount_by_day *  $diffence_days;

                    return [
                        'total_penalty' => $total_penalty,
                        'id' => $row_payment->id,
                        'date_payment' => $row_payment->date_payment,
                        'payment' => $row_payment->amount,
                        'penalty_amount' => $row_payment->penalty_amount,
                        'tasa' => $row_payment->tasa,
                        'paid' => $row_payment->paid,
                        'diffence_days' => $diffence_days,
                        'total' => $total,
                        'installment_number' => $existing_payments_count
                    ];
                });
            $customer = $row->customer;
            $user_name = $row->user->name;
            $observation = $row->observation;
            if ($row->state_type_id == '11' || $row->state === 'O') {
                $observation_credit = $row->sale_note_credit->reason_to_anulate_credit;
                $observation .= " " . $observation_credit;
            }
            return [
                'penalty_amount_by_day' => $penalty_amount_by_day,
                'is_cash' => (bool) $row->is_cash,
                'is_product' => (bool) $row->is_product,
                'user_name' => $user_name,
                'id' => $row->id,
                'status' => $row->status,
                'date_of_issue' => $row->date_of_issue->format('Y-m-d'),
                'customer' => ["name" => $customer->name, "number" => $customer->number],
                'number' => $row->number_full,
                'advances' => $advances,
                'payments' => $payments,
                'type_payment' => $row->type_payment,
            ];
        });

        $company = Company::first();
        $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;
        return (new ReportCreditDailyExport)
            ->records($records)
            ->company($company)
            ->establishment($establishment)
            ->download('Reporte_Diario_Crédito_Pagan_Hoy_' . Carbon::now() . '.xlsx');
    }
    public function daily_cash_excel(Request $request)
    {

        $records = $this->get_daily_cash_records($request)->get()->transform(function ($row) {
            $advances  = $row->advances;
            $paid = $row->paid;
            $sale_note_credit = $row->sale_note_credit;
            $penalty_amount_by_day = $sale_note_credit->penalty_amount_by_day;
            // $payment = Payment::where('sale_note_id', $row->id);
            $today = Carbon::now()->startOfDay();
            $payments = Payment::where('sale_note_id', $row->id)
                ->where('paid', 0)
                ->where('date_payment', '<=', $today)
                ->get()
                ->transform(function ($row_payment, $key) use (&$row, &$paid, $penalty_amount_by_day) {
                    $existing_payments_count = Payment::where('sale_note_id', $row->id)
                        ->where('id', '<=', $row_payment->id)
                        ->count();
                    if ($row->paid == 0) {
                        $paid = false;
                        $row->paid = false;
                    }
                    $diffence_days = 0;
                    if ($row_payment->date_payment) {
                        $diffence_days = Carbon::parse($row_payment->date_payment)->diffInDays(Carbon::now()->startOfDay(), false);
                    }
                    $total = $row_payment->amount + $row_payment->penalty_amount;
                    $total_penalty = $penalty_amount_by_day *  $diffence_days;

                    return [
                        'total_penalty' => $total_penalty,
                        'id' => $row_payment->id,
                        'date_payment' => $row_payment->date_payment,
                        'payment' => $row_payment->amount,
                        'penalty_amount' => $row_payment->penalty_amount,
                        'tasa' => $row_payment->tasa,
                        'paid' => $row_payment->paid,
                        'diffence_days' => $diffence_days,
                        'total' => $total,
                        'installment_number' => $existing_payments_count
                    ];
                });
            $customer = $row->customer;
            $user_name = $row->user->name;
            $observation = $row->observation;
            if ($row->state_type_id == '11' || $row->state === 'O') {
                $observation_credit = $row->sale_note_credit->reason_to_anulate_credit;
                $observation .= " " . $observation_credit;
            }
            return [
                'penalty_amount_by_day' => $penalty_amount_by_day,
                'is_cash' => (bool) $row->is_cash,
                'is_product' => (bool) $row->is_product,
                'user_name' => $user_name,
                'id' => $row->id,
                'status' => $row->status,
                'date_of_issue' => $row->date_of_issue->format('Y-m-d'),
                'customer' => ["name" => $customer->name, "number" => $customer->number],
                'number' => $row->number_full,
                'advances' => $advances,
                'payments' => $payments,
                'type_payment' => $row->type_payment,
            ];
        });

        $company = Company::first();
        $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;
        return (new ReportCreditDailyExport)
            ->records($records)
            ->company($company)
            ->establishment($establishment)
            ->download('Reporte_Diario_Crédito_' . Carbon::now() . '.xlsx');
    }
    public function index_cash_filter()
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

    private function get_product_records($request)
    {
        $period = $this->getDatesOfPeriod($request);

        $type = $request->credit_type;
        $params = (object)[
            'date_start' => $period['d_start'],
            'date_end' => $period['d_end'],
        ];

        // Inicializamos el query base
        $records = SaleNoteItem::whereHas('sale_note.creditPayments');

        // Filtrar por fechas
        if ($params->date_start && $params->date_end) {
            $records = $records->whereHas('sale_note', function ($query) use ($params) {
                $query->whereBetween('date_of_issue', [$params->date_start, $params->date_end]);
            });
        }

        // Filtrar por tipo de crédito
        if ($type != null) {
            if ($type == 'is_product') {
                $records = $records->whereHas('sale_note', function ($query) {
                    $query->where('is_product', true)
                        ->where('status', '<>', 'R')
                        ->where('state_type_id', '!=', 11);
                });
            }
            if ($type == 'is_cash') {
                $records = $records->whereHas('sale_note', function ($query) {
                    $query->where('is_cash', true);
                });
            }
        }

        $records = $records->get()->groupBy(function ($saleNoteItem) {
            return $saleNoteItem->sale_note->total . '|' . $saleNoteItem->sale_note->type_payment . '|' . $saleNoteItem->sale_note->creditPayments->first()->tasa . '|' . $saleNoteItem->item->purchase_unit_price . '|' . $saleNoteItem->sale_note->advances;
        })->map(function ($group) {
            $total_advances = $group->sum(function ($saleNoteItem) {
                $saleNote = $saleNoteItem->sale_note;
                $item_total = $saleNoteItem->total;
                $sale_note_total = $saleNote->total;
                $proportion = $item_total / $sale_note_total;
                return $saleNote->advances * $proportion;
            });


            $total_penalties = $group->sum(function ($saleNoteItem) {
                $saleNote = $saleNoteItem->sale_note;
                $item_total = $saleNoteItem->total;
                $sale_note_total = $saleNote->total;

                $proportion = $item_total / $sale_note_total;

                $penalty_amount = $saleNote->creditPayments
                    ->where('paid', 0)
                    ->sum('penalty_amount');

                return $penalty_amount * $proportion;
            });
            $product = $group->first()->item->description;
            $total_count = $group->sum('total');
            // $total_advances = $group->sum('sale_note.advances');
            $tasa = $group->first()->sale_note->creditPayments->first()->tasa;
            $tasa_percentage = ($tasa / 100)*$group->first()->sale_note->month;
            $gain =  ($total_count - $total_advances) * $tasa_percentage;
            $gain = round($gain, 2);
            $total_gain = $total_penalties + $gain;
            return [
                'sale_note_id' => $group->first()->sale_note->id,
                'product' => $product,
                'total_penalties' => $total_penalties,
                'total' => floatval($group->first()->total),
                'type_payment' => $group->first()->sale_note->type_payment,
                'tasa' => $group->first()->sale_note->creditPayments->first()->tasa,
                'count' => $group->count(),
                'total_count' => $group->sum('total'),
                'purchase_unit_price' => floatval($group->first()->item->purchase_unit_price),
                'gain' => $gain,
                'total_gain' => $total_gain,
            ];
        });

        return $records->values();
    }

    private function get_cash_records($request)
    {
        $period = $this->getDatesOfPeriod($request);

        $type = $request->credit_type;
        $params = (object)[
            'date_start' => $period['d_start'],
            'date_end' => $period['d_end'],
        ];
        // Inicializamos el query base
        $records = SaleNote::whereHas('creditPayments');

        // Filtrar por fechas
        if ($params->date_start && $params->date_end) {
            $records = $records->whereBetween('date_of_issue', [$params->date_start, $params->date_end])
                ->where('status', '!=', 'R')
                ->where('state_type_id', '!=', '11');
        }

        // Filtrar por tipo de crédito
        if ($type != null) {
            if ($type == 'is_product') {
                $records = $records->where('is_product', true);
            }
            if ($type == 'is_cash') {
                $records = $records->where('is_cash', true);
            }
        }

        $records = $records->orderBy('date_of_issue', 'desc')->get()->groupBy(function ($saleNote) {
            return $saleNote->total . '|' . $saleNote->type_payment . '|' . $saleNote->creditPayments->first()->tasa . '|' . $saleNote->advances;
        })->map(function ($group) {
            $total_penalties = $group->sum(function ($saleNote) {
                return $saleNote->creditPayments
                    ->where('paid', 0)
                    ->sum('penalty_amount');
            });
            $total_count = $group->sum('total');
            $total_advances = $group->sum('advances');
            $tasa = $group->first()->creditPayments->first()->tasa;
            $tasa_percentage = $tasa / 100;
            $gain =  ($total_count - $total_advances) * $tasa_percentage;
            $gain = round($gain, 2);
            $total_gain = $total_penalties + $gain;
            return [
                'total_penalties' => $total_penalties,
                'total' => floatval($group->first()->total),
                'type_payment' => $group->first()->type_payment,
                'tasa' => $group->first()->creditPayments->first()->tasa,
                'count' => $group->count(),
                'total_count' => $group->sum('total'),
                'gain' => $gain,
                'total_gain' => $total_gain,
            ];
        });

        return $records->values();
    }
    public function index_cash_records(Request $request)
    {
        $records = $this->get_cash_records($request);
        return [
            'records' => $records,
        ];
    }

    public function index_cash_excel(Request $request)
    {
        $type = $request->credit_type;
        $type_title = '';
        if ($type != null) {
            if ($type == 'is_product') {
                $type_title = 'Hogar';
            }
            if ($type == 'is_cash') {
                $type_title = 'Efectivo';
            }
        }
        $records = $this->get_cash_records($request);
        $company = Company::first();
        $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;
        return (new ReportCreditTypeCashExport)
            ->records($records)
            ->company($company)
            ->establishment($establishment)
            ->download('Reporte_Crédito_' . $type_title . '_' . Carbon::now() . '.xlsx');
    }
    public function index_product_records(Request $request)
    {
        $records = $this->get_product_records($request);
        return [
            'records' => $records,
        ];
    }

    public function index_product_excel(Request $request)
    {
        $type = $request->credit_type;
        $type_title = '';
        if ($type != null) {
            if ($type == 'is_product') {
                $type_title = 'Hogar';
            }
            if ($type == 'is_cash') {
                $type_title = 'Efectivo';
            }
        }
        $records = $this->get_product_records($request);
        $company = Company::first();
        $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;
        return (new ReportCreditTypeProductExport)
            ->records($records)
            ->company($company)
            ->establishment($establishment)
            ->download('Reporte_Crédito_' . $type_title . '_' . Carbon::now() . '.xlsx');
    }
    public function index_cash_pdf(Request $request)
    {
        $records = $this->get_cash_records($request);
        return [
            'records' => $records,
        ];
    }


    public function records(Request $request)
    {
        $paid = $request->paid ? ($request->paid == "1") : null;
        $isFromAdmin = $request->isFromAdmin;
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
        if ($isFromAdmin) {
            $records = $records->where('state_type_id', '!=', '11');
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
        if ($paid) {
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
        $isFromAdmin = $request->isFromAdmin;
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
        if ($isFromAdmin) {
            $records = $records->where('state_type_id', '!=', '11');
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
                    'number' => $row->number_full,
                    'dues' => $dues,
                    'customer_id' => $row->customer_id,
                    'date_of_due' => $date_of_due,
                    'is_cash' => $row->is_cash,
                    'is_product' => $row->is_product,
                    'customer' => ["name" => $customer->name, "number" => $customer->number, "address" => $customer->address],
                    'state' => $row->canceled ? 'PAGADO' : 'PENDIENTE',
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

        $pdf = PDF::loadView('report::credits.report_pdf', compact("records", "company", "establishment"))
            ->setPaper('a4', 'landscape');

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
                // $total_paid = SaleNotePayment::where('sale_note_id', $row->id)->sum('payment');
                $total_paid = Payment::where('sale_note_id', $row->id)->sum('amount_paid');
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
                    'difference_payment' => $total_paid - $row->total,
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

        // $period = $this->getDatesOfPeriod($request);
        $paid = $request->paid;
        $status = $request->status;
        $period = $this->getDatesOfPeriod($request);
        $isFromAdmin = $request->isFromAdmin;
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
        if ($isFromAdmin) {
            $records = $records->where('state_type_id', '!=', '11');
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
                $advances  = $row->advances;
                $payment = Payment::where('sale_note_id', $row->id);
                $int = 0;
                if ($payment->count() > 0) {
                    $payment_first = $payment->first();

                    $int = ($row->total - $advances) * ($payment_first->tasa / 100);
                }
                $total_number_payments = $payment->count();
                $payment_not_paid = $payment->where('paid', 0)
                    ->where('date_payment', '<=', Carbon::now()->startOfDay())
                    ->orderBy('date_payment', 'desc');
                $last_payment =  Payment::where('sale_note_id', $row->id)
                    ->where('paid', 0)
                    ->orderBy('date_payment', 'asc')
                    ->first();
                $quote_payment = $last_payment ? $last_payment->amount :0;
                $dues = $payment_not_paid->count();
                $date_of_due = ($last_payment) ? $last_payment->date_payment : null;
                $differenc_days = 0;
                if ($date_of_due && $dues > 0) {
                    if (is_object($date_of_due)) {
                        $date_of_due = $date_of_due->format('Y-m-d');
                    }
                    $differenc_days = Carbon::parse($date_of_due)->diffInDays(Carbon::now()->startOfDay(), false);
                }

                $customer = $row->customer;
                $amount_due = 0;
                $penalty_amount = 0;
                $total_amount = 0;
                if ($last_payment == null) {
                    $last_paid =  Payment::where('sale_note_id', $row->id)
                        ->where('paid', 1)
                        ->orderBy('date_payment', 'asc')
                        ->first();
                    $amount_due = $last_paid->amount;
                    $penalty_amount = $last_paid->penalty_amount;
                } else {
                    $amount_due = $last_payment->amount;
                    $penalty_amount = $last_payment->penalty_amount;
                }
                $total_amount = $amount_due + $penalty_amount;
                $total_gain = ($total_number_payments * $quote_payment) - ($row->total - $row->advances);
                $all_records[] = [
                    'total_quotes_payment' => $total_number_payments * $quote_payment,
                    'total_number_payments' => $total_number_payments,
                    'quote_payment' => number_format($quote_payment, 2, ".", ""),
                    'id' => $row->id,
                    'date_of_issue' => $row->date_of_issue->format('Y-m-d'),
                    'customer' => ["name" => $customer->name, "number" => $customer->number, "address" => $customer->address],
                    'number' => $row->number_full,
                    'customer_id' => $row->customer_id,
                    'dues' => $dues,
                    'int' => $total_gain,
                    'total_net' => $row->total - $row->advances,
                    'total' => $row->total - $row->advances + $int,
                    'date_of_due' => $date_of_due,
                    'is_cash' => $row->is_cash,
                    'is_product' => $row->is_product,
                    'state' => $row->canceled ? 'PAGADO' : 'PENDIENTE',
                    // 'amount_due' => number_format($amount_due, 2, ".", ""),
                    'amount_due' => number_format($amount_due, 2, ".", ""),
                    'penalty_amount' => number_format($penalty_amount, 2, ".", ""),
                    'total_amount' => number_format($total_amount, 2, ".", ""),
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
