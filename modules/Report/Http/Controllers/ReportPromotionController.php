<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Modules\Report\Traits\ReportTrait;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\User;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Payment;
use App\Models\Tenant\PromotionDocumentCustomer;
use App\Models\Tenant\PromotionReceived;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\SaleNoteItem;
use Carbon\Carbon;
use Modules\Report\Exports\ReportCreditDailyExport;
use Modules\Report\Exports\ReportCreditExport;
use Modules\Report\Exports\ReportCreditTypeCashExport;
use Modules\Report\Exports\ReportCreditTypeProductExport;
use Modules\Report\Exports\ReportPromotionDocumentExport;
use Modules\Report\Http\Resources\ReportCreditCollection;
use Modules\Report\Http\Resources\ReportCreditDailyCollection;
use Modules\Report\Http\Resources\ReportPromotionDocumentCollection;

class ReportPromotionController extends Controller
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
        $configuration = Configuration::first();
        return view('report::promotions.index', compact('configuration'));
    }


    public function detail($document_customer_id)
    {
        $document_customer = PromotionDocumentCustomer::findOrFail($document_customer_id);
        $receiveds = PromotionReceived::where('promotion_document_customer_id', $document_customer_id)->get()->transform(function ($row) {
            return [
                'id' => $row->id,
                'product' => $row->item->description,
                'quantity' => $row->quantity
            ];
        });

        return [
            'success' => true,
            'document_customer' => $document_customer,
            'receiveds' => $receiveds
        ];
    }








    public function records(Request $request)
    {
        $records = $this->getRecords($request);
        return new ReportPromotionDocumentCollection($records->paginate(config('tenant.items_per_page')));
    }

    private function getRecords($request)
    {   
        $configuration = Configuration::first();
        $records = PromotionDocumentCustomer::query();
        if ($configuration->promotions_by_points) {
            $records = $records->whereHas('promotion_document', function ($query) use ($configuration) {
                $query->where('is_points', $configuration->promotions_by_points);
            });
        }
        $period = $this->getDatesOfPeriod($request);
        $person_id = $request->person_id;
        if ($period['d_start'] && $period['d_end']) {
            $records = $records->whereBetween('created_at', [$period['d_start'], $period['d_end']]);
        }
        if ($person_id) {
            $records = $records->where('customer_id', $person_id);
        }

        return $records;
    }

    public function pdf(Request $request)
    {
        $configuration = Configuration::first();
        $company = Company::first();
        $records = $this->getRecords($request)->get()->transform(function ($row) {
            return (object) [
                'id' => $row->id,
                'customer_name' => $row->customer->name,
                'promotion_name' => $row->promotion_document->description,
                'points' => $row->points,
                'acc_total' => $row->acc_total,
            ];
        });
        $establishment = Establishment::first();
        $pdf = PDF::loadView('report::promotions.report_pdf', compact("records", "company", "establishment"))
            ->setPaper('a4', 'landscape');

        $filename = 'Reporte_Promociones_' . date('YmdHis');

        return $pdf->stream($filename . '.pdf');
    }



    public function excel(Request $request)
    {

        $records = $this->getRecords($request)->get()->transform(function ($row) {
            return  (object)[
                'id' => $row->id,
                'customer_name' => $row->customer->name,
                'promotion_name' => $row->promotion_document->description,
                'points' => $row->points,
                'acc_total' => $row->acc_total,
            ];
        });
        $company = Company::first();

        return (new ReportPromotionDocumentExport)
            ->records($records)
            ->company($company)
            ->download('Reporte_Promociones_' . Carbon::now() . '.xlsx');
    }
}
