<?php

namespace Modules\Report\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Tenant\Company;
use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Establishment;
use Modules\Report\Traits\ReportTrait;
use Modules\Report\Exports\CustomerExport;
use App\Models\Tenant\Catalogs\DocumentType;
use Modules\Report\Http\Resources\DocumentCollection;


class ReportCustomerController extends Controller
{
    use ReportTrait;

    public function filter() {

        $document_types = [];

        $persons = $this->getPersons('customers');

        $establishments = Establishment::all()->transform(function($row) {
            return [
                'id' => $row->id,
                'name' => $row->description
            ];
        });

        return compact('document_types','establishments','persons');
    }


    public function index() {

        return view('report::customers.index');
    }

    public function records(Request $request)
    {
        $records = $this->getRecordsCustomers($request->all(), Document::class,SaleNote::class);
        return new DocumentCollection($records->paginate(config('tenant.items_per_page')));
    }



    public function getRecordsCustomers($request, $model,$model_sale){
        // dd($request['period']);
        $document_type_id = $request['document_type_id'];
        $establishment_id = $request['establishment_id'];
        $period = $request['period'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];

        $month_start = $request['month_start'];
        $month_end = $request['month_end'];
        $person_id = $request['person_id'];
        $type_person = $request['type_person'];
        $d_start = null;
        $d_end = null;

        switch ($period) {
            case 'month':
                $d_start = Carbon::parse($month_start.'-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_start.'-01')->endOfMonth()->format('Y-m-d');
                // $d_end = Carbon::parse($month_end.'-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'between_months':
                $d_start = Carbon::parse($month_start.'-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_end.'-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'date':
                $d_start = $date_start;
                $d_end = $date_start;
                // $d_end = $date_end;
                break;
            case 'between_dates':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
        }

        $records = $this->dataCustomers_documents($document_type_id, $establishment_id, $d_start, $d_end, $person_id, $type_person, $model,$model_sale);

        return $records;

    }


    private function dataCustomers_documents($document_type_id, $establishment_id, $date_start, $date_end, $person_id, $type_person, $model,$model_sale)
    {
        $data = DB::table('document_payments')
                        ->join('documents', 'documents.id', '=', 'document_payments.document_id')
                        ->whereBetween('document_payments.date_of_payment', [$date_start, $date_end])
                        ->select('documents.id','documents.soap_type_id',DB::raw("document_payments.date_of_payment as date_of_issue"),'documents.customer','documents.state_type_id','documents.document_type_id','documents.series','documents.number','documents.total_prepayment','documents.total_charge','documents.total_discount','documents.total_exportation','documents.total_free','documents.total_taxed','documents.total_unaffected','documents.total_exonerated','documents.total_igv','documents.total_base_isc','documents.total_isc','documents.total_base_other_taxes','documents.total_other_taxes','documents.total_taxes','documents.total_value',"documents.total",DB::raw("document_payments.id as payment_id"))
                        ->where('customer_id', $person_id)
                        ->whereIn('document_type_id', ['01','03']);

        $data_saleNote = DB::table('sale_note_payments')
                        ->join('sale_notes', 'sale_notes.id', '=', 'sale_note_payments.sale_note_id')
                         ->whereBetween('sale_note_payments.date_of_payment', [$date_start, $date_end])
                         ->select('sale_notes.id','sale_notes.soap_type_id',DB::raw("sale_note_payments.date_of_payment as date_of_issue"),'sale_notes.customer','sale_notes.state_type_id','sale_notes.document_type_id','sale_notes.series','sale_notes.number','sale_notes.total_prepayment','sale_notes.total_charge','sale_notes.total_discount','sale_notes.total_exportation','sale_notes.total_free','sale_notes.total_taxed','sale_notes.total_unaffected','sale_notes.total_exonerated','sale_notes.total_igv','sale_notes.total_base_isc','sale_notes.total_isc','sale_notes.total_base_other_taxes','sale_notes.total_other_taxes','sale_notes.total_taxes','sale_notes.total_value',"sale_notes.total",DB::raw("sale_note_payments.id as payment_id"))
                        ->where('customer_id', $person_id)
                       ->where('total','>','0.00');

        $document_pendiente = DB::table('documents')
                        ->whereBetween('documents.date_of_issue', [$date_start, $date_end])
                       ->select('documents.id','documents.soap_type_id','documents.date_of_issue','documents.customer','documents.state_type_id','documents.document_type_id','documents.series','documents.number','documents.total_prepayment','documents.total_charge','documents.total_discount','documents.total_exportation','documents.total_free','documents.total_taxed','documents.total_unaffected','documents.total_exonerated','documents.total_igv','documents.total_base_isc','documents.total_isc','documents.total_base_other_taxes','documents.total_other_taxes','documents.total_taxes','documents.total_value','documents.total')
                        ->addSelect(DB::raw("'payment_id'"))
                       ->where('customer_id', $person_id)
                       ->where('notpayment',1)
                       ->whereIn('document_type_id', ['01','03']);

        $data_saleNote_notpayment = DB::table('sale_notes')
                        ->whereBetween('sale_notes.date_of_issue', [$date_start, $date_end])
                       ->select('sale_notes.id','sale_notes.soap_type_id','sale_notes.date_of_issue','sale_notes.customer','sale_notes.state_type_id','sale_notes.document_type_id','sale_notes.series','sale_notes.number','sale_notes.total_prepayment','sale_notes.total_charge','sale_notes.total_discount','sale_notes.total_exportation','sale_notes.total_free','sale_notes.total_taxed','sale_notes.total_unaffected','sale_notes.total_exonerated','sale_notes.total_igv','sale_notes.total_base_isc','sale_notes.total_isc','sale_notes.total_base_other_taxes','sale_notes.total_other_taxes','sale_notes.total_taxes','sale_notes.total_value','sale_notes.total')
                        ->addSelect(DB::raw("'payment_id'"))
                       ->where('customer_id', $person_id)
                       ->where('notpayment',1);

        $data_notpayment=$document_pendiente->union($data_saleNote_notpayment);
       // return $data_notpayment;
        $data_payment=$data_saleNote->union($data);
     //   dd($data_notpayment->union($data_payment)->orderBy('date_of_issue','asc')->orderBy('number','asc')->get());
       return  $data_notpayment->union($data_payment)->orderBy('date_of_issue','asc');

        // $data_result_pendiente=$data_saleNote_pendiente->union($data_pendiente);

        //return $data_payment->union($data_result_pendiente);
    }

    public function pdf(Request $request) {

      $company = Company::first();
      $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;
        //$records = $this->getRecordsCustomers($request->all(), Document::class,SaleNote::class);
      //  $datas = new DocumentCollection($records->get());
      $records = $this->getRecordsCustomers($request->all(), Document::class,SaleNote::class);

      $datas =new DocumentCollection($records->get());
      $data_pendiente= json_decode(json_encode($datas,true));
        $date_start= $request->date_end;
        $date_end= $request->date_end;
        $pdf = PDF::loadView('report::customers.report_pdf', compact("data_pendiente","company","establishment","date_start","date_end"))
        ->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function excel(Request $request) {

        $company = Company::first();
        $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;
        $datas =new DocumentCollection($this->getRecordsCustomers($request->all(), Document::class,SaleNote::class)->get());

        $records= json_decode(json_encode($datas,true));
         return (new CustomerExport)
                ->records($records)
                ->company($company)
                ->establishment($establishment)
                ->download('Reporte_Ventas_por_Cliente_'.Carbon::now().'.xlsx');

    }
}
