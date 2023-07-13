<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Modules\Report\Traits\ReportTrait;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Company;
use Carbon\Carbon;
use Modules\Consignment\Models\Consignment;
use Modules\Report\Exports\ReportConsignmentExport;
use Modules\Report\Http\Resources\ReportConsignmentCollection;

class ReportConsignmentController extends Controller
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

        return view('report::consignment.index');
    }
    function correctDate($request)
    {
        $period = $request->period;
        $date_end = $request->date_end;
        $date_of_end = $request->date_of_end;
        $date_start = $request->date_start;
        $liquidated = $request->liquidated;
        $month_end = $request->month_end;
        $month_start = $request->month_start;
        $passed = true;
        if ($period == 'month') {
            if ($month_start == null) {
                $passed = false;
            }
        }


        if ($period == 'between_months') {
            if ($month_start == null || $month_end == null) {
                $passed = false;
            }
        }
        if ($period == 'between_dates') {
            if ($date_start == null || $date_end == null) {
                $passed = false;
            }
        }
        if ($period == 'date') {
            if ($date_start == null) {
                $passed = false;
            }
        }
        return $passed;
    }
    public function records(Request $request)
    {
        $period = $this->getDatesOfPeriod($request);
        $person_id = $request->person_id;
        $date_of_end = $request->date_of_end;
        $liquidated = $request->liquidated;
        $params = (object)[
            'date_start' => $period['d_start'],
            'date_end' => $period['d_end'],
        ];

        $records = Consignment::query();

        if ($this->correctDate($request)) {
            $records = $records->whereBetween('date_of_issue', [$params->date_start, $params->date_end]);
        }

        if ($person_id) {
            $records = $records->where('person_id', $person_id);
        }
        if ($date_of_end) {
            $records = $records->where('date_of_end', $date_of_end);
        }
        if ($liquidated) {
            $records = $records->where('liquidated', $liquidated);
        }

        $records->orderBy('created_at', 'desc');

        return new ReportConsignmentCollection($records->paginate(config('tenant.items_per_page')));
    }



    public function pdf(Request $request)
    {
        $company = Company::first();
        $establishment = Establishment::first();
        $period = $this->getDatesOfPeriod($request);
        $person_id = $request->person_id;
        $date_of_end = $request->date_of_end;
        $liquidated = $request->liquidated;
        $params = (object)[
            'date_start' => $period['d_start'],
            'date_end' => $period['d_end'],
        ];

        $records = Consignment::query();

        if ($this->correctDate($request)) {
            $records = $records->whereBetween('date_of_issue', [$params->date_start, $params->date_end]);
        }

        if ($person_id) {
            $records = $records->where('person_id', $person_id);
        }
        if ($date_of_end) {
            $records = $records->where('date_of_end', $date_of_end);
        }
        if ($liquidated) {
            $records = $records->where('liquidated', $liquidated);
        }
        $all_records = [];
        $records->orderBy('created_at', 'desc')
        ->chunk(50, function ($rows) use (&$all_records) {

            foreach ($rows as $row) {
                $number = str_pad($row->id, 8, "0", STR_PAD_LEFT);
                $items = $row->items;
                $count_items = $items->count();
                $total = 0;
                foreach ($items as $item) {
                    $total += $item->original_quantity * $item->price;
                }
                $penalty = null;
                if ($row->penalty) {
                    $consignment_penalty = $row->penalty;
                    $amount = $consignment_penalty->amount;
                    if ($consignment_penalty->type == 'percentage') {
                        $penalty = $amount . '%';
                    } else {
                        $penalty = 'S/ ' . $amount;
                    }
                }
                $all_records[] = [
                    'id' => $row->id,
                    'number' => $number,
                    'date_of_issue' => Carbon::parse($row->date_of_issue)->format('Y-m-d'),
                    'date_of_end' => Carbon::parse($row->date_of_end)->format('Y-m-d'),
                    'person' => ["name" => $row->person->name, "number" => $row->person->number],
                    'count_items' => $count_items,
                    "total" => $total,
                    "penalty" => $penalty,
                    "liquidated" => $row->liquidated  == 1 ? 'Liquidado' : 'Por liquidar',
                ];
            }
        });
        
        $records = $all_records;

      

        $pdf = PDF::loadView('report::consignment.report_pdf', compact("records", "company", "establishment"));

        $filename = 'Reporte_Crédito_' . date('YmdHis');

        return $pdf->download($filename . '.pdf');
    }




    public function excel(Request $request)
    {

        $company = Company::first();
        $establishment = Establishment::first();
        $period = $this->getDatesOfPeriod($request);
        $person_id = $request->person_id;
        $date_of_end = $request->date_of_end;
        $liquidated = $request->liquidated;
        $params = (object)[
            'date_start' => $period['d_start'],
            'date_end' => $period['d_end'],
        ];

        $records = Consignment::query();

        if ($this->correctDate($request)) {
            $records = $records->whereBetween('date_of_issue', [$params->date_start, $params->date_end]);
        }

        if ($person_id) {
            $records = $records->where('person_id', $person_id);
        }
        if ($date_of_end) {
            $records = $records->where('date_of_end', $date_of_end);
        }
        if ($liquidated) {
            $records = $records->where('liquidated', $liquidated);
        }
        $all_records = [];
        $records->orderBy('created_at', 'desc')
        ->chunk(50, function ($rows) use (&$all_records) {

            foreach ($rows as $row) {
                $number = str_pad($row->id, 8, "0", STR_PAD_LEFT);
                $items = $row->items;
                $count_items = $items->count();
                $total = 0;
                foreach ($items as $item) {
                    $total += $item->original_quantity * $item->price;
                }
                $penalty = null;
                if ($row->penalty) {
                    $consignment_penalty = $row->penalty;
                    $amount = $consignment_penalty->amount;
                    if ($consignment_penalty->type == 'percentage') {
                        $penalty = $amount . '%';
                    } else {
                        $penalty = 'S/ ' . $amount;
                    }
                }
                $all_records[] = [
                    'id' => $row->id,
                    'number' => $number,
                    'date_of_issue' => Carbon::parse($row->date_of_issue)->format('Y-m-d'),
                    'date_of_end' => Carbon::parse($row->date_of_end)->format('Y-m-d'),
                    'person' => ["name" => $row->person->name, "number" => $row->person->number],
                    'count_items' => $count_items,
                    "total" => $total,
                    "penalty" => $penalty,
                    "liquidated" => $row->liquidated  == 1 ? 'Liquidado' : 'Por liquidar',
                ];
            }
        });
        
        $records = $all_records;


        //sort records by key dues(int) of each element
      

        return (new ReportConsignmentExport)
            ->records($records)
            ->company($company)
            ->establishment($establishment)
            ->download('Reporte_Consignamiento_' . Carbon::now() . '.xlsx');
    }
}
