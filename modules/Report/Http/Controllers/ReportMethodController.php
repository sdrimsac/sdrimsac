<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Box;
use App\Models\Tenant\Company;
use App\Models\Tenant\Establishment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Report\Exports\MethodExport;
use Modules\Report\Http\Resources\BoxCollection;
use Modules\Report\Traits\ReportTrait;

class ReportMethodController extends Controller
{

    use ReportTrait;

    public function index()
    {

        return view('report::methods.index');
    }
    public function filter()
    {

        $persons = $this->getPersons('customers');
        $establishments = Establishment::all();

        return compact('persons', 'establishments');
    }

    public function records(Request $request)
    {

        $boxes = $this->getRecords($request);

        return new BoxCollection($boxes->paginate(config('tenant.items_per_page')));
    }

    public function excel(Request $request)
    {
        $establishment = Establishment::where('id', $request->establishment_id)->first();
        $company = Company::first();
        $records = $this->getRecords($request)->get();
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        return (new MethodExport())
            ->records($records)
            ->company($company)
            ->dateStart($date_start)
            ->dateEnd($date_end)
            ->establishment($establishment) 
            ->download('Reporte_Metodos_' . Carbon::now() . '.xlsx');
    }

    public function getRecords(Request $request)
    {
        $establishment_id = $request['establishment_id'];
        $period = $request['period'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];

        $month_start = $request['month_start'];
        $month_end = $request['month_end'];
        $person_id = $request['person_id'];
        $method = $request['method'];
        $d_start = null;
        $d_end = null;

        switch ($period) {
            case 'month':
                $d_start = Carbon::parse($month_start . '-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_start . '-01')->endOfMonth()->format('Y-m-d');
                // $d_end = Carbon::parse($month_end.'-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'between_months':
                $d_start = Carbon::parse($month_start . '-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_end . '-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'date':
                $d_start = $date_start;
                $d_end = $date_start;
                break;
            case 'between_dates':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
        }
        $boxes = Box::query();

        if ($establishment_id) {
            $boxes->where('establishment_id', $establishment_id);
        }
        if ($d_start && $d_end) {
            $boxes->whereBetween('date', [$d_start, $d_end]);
        }

        if ($person_id) {
            $boxes->where(function ($query) use ($person_id) {
                $query->whereHas('document', function ($query) use ($person_id) {
                    $query->where('customer_id', $person_id);
                })->orWhereHas('sale_note', function ($query) use ($person_id) {
                    $query->where('customer_id', $person_id);
                })->orWhereHas('sale_note_payment', function ($query) use ($person_id) {
                    $query->whereHas('associated_record_payment', function ($query) use ($person_id) {
                        $query->where('customer_id', $person_id);
                    });
                })->orWhereHas('document_payment', function ($query) use ($person_id) {
                    $query->whereHas('document', function ($query) use ($person_id) {
                        $query->where('customer_id', $person_id);
                    });
                });
            });
        }

        if ($method) {
            $boxes->where('method', 'like', '%' . $method . '%');
        }

        return $boxes;
    }
    public function columns()
    {

        return [


            'customer' => 'Cliente',
            'method' => 'Metodo',
            'date' => 'Fecha',


        ];
    }
}
