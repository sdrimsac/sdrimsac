<?php

namespace Modules\Report\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Tenant\Company;
use App\Models\Tenant\Invoice;
use App\Models\Tenant\Dispatch;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Tenant\DocumentPayment;
use App\Models\Tenant\SaleNotePayment;
use Modules\Report\Exports\NoPaidExport;
use Modules\Dashboard\Helpers\DashboardView;
use Modules\Report\Http\Resources\QuotationCollection;


class ReportUnpaidController extends Controller
{

    public function type(Request $request) {
        $company = Company::first();
        if($request->type=="pdf"){

           //return [
           //     'records' => (new DashboardView())->getUnpaid($request->all())
           //];
            $records=(new DashboardView())->getUnpaid($request->all());
         //  $records=$records[0];
            $date_start = $request['date_start'];
            $date_end = $request['date_end'];
            $companies=Company::first();
            $pdf = PDF::loadView('tenant.reports.no_paid.report_pdf', compact("companies","records","date_start","date_end"))->setPaper('a4');
            return $pdf->stream('Reporte_cuentas_'.date('YmdHis').'.pdf');
        }else{
            return (new NoPaidExport)
            ->company($company)
            ->records((new DashboardView())->getUnpaid($request->all()))
            ->download('Reporte_Cuentas_Por_Cobrar'.Carbon::now().'.xlsx');
        }


    }
}
