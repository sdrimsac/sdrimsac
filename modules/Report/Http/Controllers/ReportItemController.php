<?php

namespace Modules\Report\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tenant\Item;
use Illuminate\Http\Request;
use App\Models\Tenant\Company;
use App\Models\Tenant\Document;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant\DocumentItem;
use App\Models\Tenant\SaleNoteItem;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Establishment;
use Modules\Report\Exports\ItemExport;
use Modules\Report\Traits\ReportTrait;
use App\Models\Tenant\Catalogs\DocumentType;
use Doctrine\Common\Collections\Collection;
use Modules\Report\Exports\ItemExport_defeated;
use Modules\Report\Http\Resources\ItemCollection;
use Modules\Report\Http\Resources\ItemDefeatedCollection;


class ReportItemController extends Controller
{
    use ReportTrait;

    public function filter() {

        $document_types = [];
        $items = $this->getItems('items');
        $establishments = [];

        return compact('document_types','establishments','items');
    }
    public function view_defeated(){
        return view('report::items.defeated');
    }
    public function defeated(Request $request){
        $document_type_id = $request->document_type_id;
        $establishment_id = $request->establishment_id;
        $period = $request->period;
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $month_start = $request->month_start;
        $month_end = $request->month_end;
        $item_id = $request->item_id;

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

        $records = DB::table('items')
        ->where('stock','>','0')
        ->whereBetween('date_of_due', [$d_start, $d_end])
        ->orderBy('description','asc');
         return  new ItemDefeatedCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function defeated_pdf(Request $request){
        $company = Company::first();
        $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;
        $document_type_id = $request->document_type_id;
        $establishment_id = $request->establishment_id;
        $period = $request->period;
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $month_start = $request->month_start;
        $month_end = $request->month_end;
        $item_id = $request->item_id;

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
        $records = DB::table('items')
        ->where('stock','>','0')
        ->whereBetween('date_of_due', [$d_start, $d_end])->orderBy('description','asc')->get();
        $pdf = PDF::loadView('report::items.report_pdf', compact("company", "establishment","records"));
        $filename = 'Reporte_productos_vencidos_'.date('YmdHis');
        return $pdf->stream($filename.'.pdf');
    }
    public function defeated_excel(Request $request){
        $company = Company::first();
        $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;    
        $document_type_id = $request->document_type_id;
        $establishment_id = $request->establishment_id;
        $period = $request->period;
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $month_start = $request->month_start;
        $month_end = $request->month_end;
        $item_id = $request->item_id;
        $d_start = null;
        $d_end = null;
        switch ($period) {
            case 'month':
                $d_start = Carbon::parse($month_start.'-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_start.'-01')->endOfMonth()->format('Y-m-d');
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
        $records = DB::table('items')
        ->whereBetween('date_of_due', [$d_start, $d_end])->get();
      //  return $records;
        return (new ItemExport_defeated)
        ->records($records)
        ->company($company)
        ->establishment($establishment)
        ->download('Reporte_Producto_vencidos'.Carbon::now().'.xlsx');
    }


    public function vendidos(){

    }
    public function index() {

        return view('report::items.index');
    }

    public function records(Request $request)
    {
        $records = $this->getRecordsItems($request->all(),DocumentItem::class,SaleNoteItem::class);
        return new ItemCollection($records->paginate(config('tenant.items_per_page')));
    }



    public function getRecordsItems($request, $model_document,$model_saleNoteItems){

        $document_type_id = $request['document_type_id'];
        $establishment_id = $request['establishment_id'];
        $period = $request['period'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $month_start = $request['month_start'];
        $month_end = $request['month_end'];
        $item_id = $request['item_id'];

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
        $records = $this->dataItems($document_type_id, $establishment_id, $d_start, $d_end, $item_id, $model_document,$model_saleNoteItems);
        return $records;
    }


    private function dataItems($document_type_id, $establishment_id, $date_start, $date_end, $item_id,$model,$model_saleNoteItems)
    {

        $data_document = $model::where('item_id', $item_id)
                        ->whereHas('document', function($query) use($date_start, $date_end){
                            $query
                            ->whereBetween('date_of_issue', [$date_start, $date_end])
                            ->whereIn('document_type_id', ['01','03'])
                            ->whereIn('state_type_id', ['01','03','05','07','13'])
                            ->latest()
                            ->whereTypeUser();
                        });
        $data_sale_note = $model_saleNoteItems::where('item_id', $item_id)
                        ->whereHas('sale_note', function($query) use($date_start, $date_end){
                            $query
                            ->whereBetween('date_of_issue', [$date_start, $date_end])
                            ->whereIn('document_type_id', ['01','03'])
                            ->whereIn('state_type_id', ['01','03','05','07','13'])
                            ->latest()
                            ->whereTypeUser();
                        });
        

        return $data_document;

    }



    public function excel(Request $request) {

        $company = Company::first();
        $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;

        $records = $this->getRecordsItems($request->all(), DocumentItem::class)->get();

        return (new ItemExport)
                ->records($records)
                ->company($company)
                ->establishment($establishment)
                ->download('Reporte_Ventas_por_Producto_'.Carbon::now().'.xlsx');

    }
}
