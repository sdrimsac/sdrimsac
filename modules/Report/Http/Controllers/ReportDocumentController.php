<?php

namespace Modules\Report\Http\Controllers;

use App\Exports\MarginUtilExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\MarginCollection;
use App\Http\Resources\Tenant\SaleNotesCollection;
use App\Models\Tenant\Box;
use App\Models\Tenant\Catalogs\DocumentType;
use App\Models\Tenant\Company;
use App\Models\Tenant\Document;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Item;
use App\Models\Tenant\Purchase;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\SaleNoteItem;
use App\Models\Tenant\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Report\Exports\DocumentExport;
use Modules\Report\Http\Resources\DocumentCollection;
use Modules\Report\Traits\ReportTrait;


class ReportDocumentController extends Controller
{
    use ReportTrait;
    protected $meses = [
        '01' => 'Enero',
        '02' => 'Febrero',
        '03' => 'Marzo',
        '04' => 'Abril',
        '05' => 'Mayo',
        '06' => 'Junio',
        '07' => 'Julio',
        '08' => 'Agosto',
        '09' => 'Setiembre',
        '10' => 'Octubre',
        '11' => 'Noviembre',
        '12' => 'Diciembre'
         
    ];
    public function __construct()
    {
        ini_set('memory_limit', '-1');
    }
    public function filter() {

        $document_types = DocumentType::whereIn('id', ['01', '03','07', '08','80'])->get();

        $persons = $this->getPersons('customers');
        $sellers = $this->getSellers();

        $establishments = Establishment::all()->transform(function($row) {
            return [
                'id' => $row->id,
                'name' => $row->description
            ];
        });

        return compact('document_types','establishments','persons', 'sellers');
    }


    public function index() {

        return view('report::documents.index');
    }

    public function records(Request $request)
    {
        $sale_notes=[];
        $documents=[];
        $document_type_id = $request['document_type_id'];
        $establishment_id = $request['establishment_id'];
        $period = $request['period'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $month_start = $request['month_start'];
        $month_end = $request['month_end'];
        $person_id = $request['person_id'];
        $type_person = $request['type_person'];
        $seller_id = $request['seller_id'];
        $d_start = null;
        $d_end = null;

        switch ($period) {
            case 'month':
                $d_start = Carbon::parse($month_start.'-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_end.'-01')->endOfMonth()->format('Y-m-d');
                // $d_end = Carbon::parse($month_end.'-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'between_months':
                $d_start = Carbon::parse($month_start.'-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_end.'-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'date':
                $d_start = $date_start;
                $d_end = $date_end;
                // $d_end = $date_end;
                break;
            case 'between_dates':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
        }
        if($document_type_id!=null){

            if($document_type_id=="01" || $document_type_id=="03"){
                $documents = DB::connection('tenant')->table('documents')
                ->select(DB::raw("id,user_id, soap_type_id,document_type_id,state_type_id,date_of_issue,total_exonerated,total_unaffected,total_free,total_taxed,total_igv,total,customer, currency_type_id,documents.series,documents.number, concat(documents.number,' ',documents.series) as 'number_full', total_exportation"))
                ->whereBetween('date_of_issue', [$d_start, $d_end])
                ->where('document_type_id', 'like', '%' . $document_type_id . '%')->OrderBy("documents.date_of_issue","asc")->latest();
              
            }else{
                $sale_notes = DB::connection('tenant')->table('sale_notes')
                ->select(DB::raw("user_id, soap_type_id,document_type_id,state_type_id,date_of_issue,total_exonerated,total_unaffected,total_free,total_taxed,total_igv,total,customer, currency_type_id,sale_notes.series,sale_notes.number, concat(sale_notes.number,' ',sale_notes.series) as 'number_full', total_exportation"))
                 ->whereBetween('date_of_issue', [$d_start, $d_end])->OrderBy("sale_notes.date_of_issue","asc")->latest();             
            }
           
        }elseif($establishment_id){
          
            $documents = DB::connection('tenant')->table('documents')
            ->select(DB::raw("user_id, soap_type_id,document_type_id,state_type_id,date_of_issue,total_exonerated,total_unaffected,total_free,total_taxed,total_igv,total,customer, currency_type_id,documents.series,documents.number, concat(documents.number,' ',documents.series) as 'number_full', total_exportation"))
            ->whereBetween('date_of_issue', [$d_start, $d_end])
            ->where('establishment_id', 'like', '%' . $establishment_id . '%')->OrderBy("documents.date_of_issue","asc")->latest();

            $sale_notes = DB::connection('tenant')->table('sale_notes')
            ->select(DB::raw("user_id, soap_type_id,document_type_id,state_type_id,date_of_issue,total_exonerated,total_unaffected,total_free,total_taxed,total_igv,total,customer, currency_type_id,sale_notes.series,sale_notes.number, concat(sale_notes.number,' ',sale_notes.series) as 'number_full', total_exportation"))
            ->whereBetween('date_of_issue', [$d_start, $d_end]) 
            ->where('establishment_id', 'like', '%' . $establishment_id . '%')->OrderBy("sale_notes.date_of_issue","asc")->latest();
        }else{
          
            if($document_type_id!=null){
                $documents = DB::connection('tenant')->table('documents')
                ->select(DB::raw("user_id, soap_type_id,document_type_id,state_type_id,date_of_issue,total_exonerated,total_unaffected,total_free,total_taxed,total_igv,total,customer, currency_type_id,documents.series,documents.number, concat(documents.number,' ',documents.series) as 'number_full', total_exportation"))
                ->where('document_type_id', 'like', '%' . $document_type_id . '%')
                ->whereBetween('date_of_issue', [$d_start, $date_end])->OrderBy("sale_notes.date_of_issue","asc")->latest();
                $sale_notes = DB::connection('tenant')->table('sale_notes')
                ->select(DB::raw("user_id, soap_type_id,document_type_id,state_type_id,date_of_issue,total_exonerated,total_unaffected,total_free,total_taxed,total_igv,total,customer, currency_type_id,sale_notes.series,sale_notes.number, concat(sale_notes.number,' ',sale_notes.series) as 'number_full', total_exportation"))
                ->whereBetween('date_of_issue', [$d_start, $d_end])->OrderBy("sale_notes.date_of_issue","asc")->latest();
               
            }else{
             //  dd($document_type_id);
                $documents = DB::connection('tenant')->table('documents')
                ->select(DB::raw("user_id, soap_type_id,document_type_id,state_type_id,date_of_issue,total_exonerated,total_unaffected,total_free,total_taxed,total_igv,total,customer, currency_type_id,documents.series,documents.number, concat(documents.number,' ',documents.series) as 'number_full', total_exportation"))
                ->whereBetween('date_of_issue', [$d_start, $d_end])->OrderBy("documents.date_of_issue","asc")->latest();
                $sale_notes = DB::connection('tenant')->table('sale_notes')
                ->select(DB::raw("user_id, soap_type_id,document_type_id,state_type_id,date_of_issue,total_exonerated,total_unaffected,total_free,total_taxed,total_igv,total,customer, currency_type_id,sale_notes.series,sale_notes.number, concat(sale_notes.number,' ',sale_notes.series) as 'number_full', total_exportation"))
                ->whereBetween('date_of_issue', [$d_start, $d_end])->OrderBy("sale_notes.date_of_issue","asc")->latest();
              
            
            }
          
        }
       
        if($person_id && $type_person){
             $column = ($type_person == 'customers') ? 'customer_id':'supplier_id';
             if($document_type_id=="01" || $document_type_id=="03"){
                 $documents =  $documents->where($column, $person_id);
            } 
            if($document_type_id=="80"){
                 $sale_notes =  $sale_notes->where($column, $person_id);
            } 
            if($document_type_id==null){
                $sale_notes =  $sale_notes->where($column, $person_id);
                $documents =  $documents->where($column, $person_id);
            }
        }
        
        if($seller_id!=null)
        {
            if($document_type_id=="01" || $document_type_id=="03"){
            $documents =  $documents->where('user_id', $seller_id);
            }
            if($document_type_id=="80"){
            $sale_notes =  $sale_notes->where('user_id', $seller_id);
            }
            if($document_type_id==null){
                $sale_notes =  $sale_notes->where('user_id', $seller_id);
                $documents =  $documents->where('user_id', $seller_id);
            }
            
        }

        if($document_type_id=="80"){
            $documents=$sale_notes;
            return new SaleNotesCollection($documents->paginate(config('tenant.items_per_page')));
         }else if($document_type_id=="01" || $document_type_id=="03"){
            $documents=$documents;
             return new SaleNotesCollection($documents->paginate(config('tenant.items_per_page')));
        }else if($sale_notes->count()>0 || $documents->count()>0){
              $documents=$documents->union($sale_notes);
              return new SaleNotesCollection($documents->paginate(config('tenant.items_per_page')));
         }else{
            return new SaleNotesCollection($documents->paginate(config('tenant.items_per_page')));
         }     
    }
    public function marginindex(){
        return view('report::documents.margin_util');
    }
    public function marginrecords(Request $request){
        $period = $request['period'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $month_start = $request['month_start'];
        $month_end = $request['month_end'];
        $user_id = $request['seller_id'];
        $establishment_id=$request['establishment_id'];
        $d_start = null;
        $d_end = null;
        $type_box = $request['type_box'];
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
                $d_end = $d_start;
                break;
            case 'between_dates':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
        }
      
        $sale_notes = SaleNote::query()
         ->with(['items', 'items.relation_item'])
         ->select('id','series','number','date_of_issue','state_type_id','customer','document_type_id','user_id','establishment_id')
         ->whereBetween('date_of_issue', [$d_start, $d_end])
         ->where('state_type_id',"!=","11")
         ->OrderBy('sale_notes.id','asc');
         if($user_id){
            $sale_notes=$sale_notes->where('user_id',$user_id);
        } 
        if($establishment_id){
            $sale_notes=$sale_notes->where('establishment_id',$establishment_id);
        }
       
         $documents = Document::query()
         ->with(['items', 'items.m_item'])
         ->select('id','series','number','date_of_issue','state_type_id','customer','document_type_id','user_id','establishment_id')
         ->whereBetween('date_of_issue', [$d_start, $d_end])
         ->where('state_type_id',"!=","11")
         ->OrderBy('documents.id','asc');
         if($user_id){
            $documents=$documents->where('user_id',$user_id);
        } 
        if($establishment_id){
            $documents=$documents->where('establishment_id',$establishment_id);
        }
         $records=$sale_notes->union($documents);
         return new MarginCollection($records->paginate(config('tenant.items_per_page')));
       
    }
    public function type (Request $request) {
        $period = $request['period'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $month_start = $request['month_start'];
        $month_end = $request['month_end'];
        $user_id = $request['seller_id'];
        $establishment_id=$request['establishment_id'];
        $typeresult=$request['typeresult'];
        $export=$request['export'];
        $d_start = null;
        $d_end = null;
        $type_box = $request['type_box'];
         
        switch ($period) {
            case 'month':
                $d_start = Carbon::parse($month_start.'-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_start.'-01')->endOfMonth()->format('Y-m-d');
                $month="Mensual";
               
                $fecha_start =Carbon::parse($d_start) ;
                $d_month_start = $fecha_start->formatLocalized('%B');
                $fecha_end =Carbon::parse($d_end) ;
                $d_month_end = $fecha_end->formatLocalized('%B');

                 break;
            case 'between_months':
                $d_start = Carbon::parse($month_start.'-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_end.'-01')->endOfMonth()->format('Y-m-d');
                $fecha_start =Carbon::parse($d_start) ;
                $d_month_start = $fecha_start->formatLocalized('%B');
                $fecha_end =Carbon::parse($d_end) ;
                $d_month_end = $fecha_end->formatLocalized('%B');
                $month="Rango de Mes";
                break;
             
            case 'date':
                $d_start = $date_start;
                $d_end = $d_start;
                $fecha_start =Carbon::parse($d_start) ;
                $d_month_start = $fecha_start->formatLocalized('%B');
                $fecha_end =Carbon::parse($d_end) ;
                $d_month_end = $fecha_end->formatLocalized('%B');
                $month="Por Fecha";
                break;
            case 'between_dates':
                $d_start = $date_start;
                $d_end = $date_end;
                $fecha_start =Carbon::parse($d_start) ;
                $d_month_start = $fecha_start->formatLocalized('%B');
                $fecha_end =Carbon::parse($d_end) ;
                $d_month_end = $fecha_end->formatLocalized('%B');
                $month="Por Rango de Fecha";
                break;
        }
        $mes=substr($d_start,5,2);
        $mes_consultar=$this->meses[$mes];
        $sale_notes = SaleNote::query()
         ->with(['items', 'items.relation_item'])
         ->select('id','series','number','date_of_issue','state_type_id','customer','document_type_id','user_id','establishment_id')
         ->whereBetween('date_of_issue', [$d_start, $d_end])
         ->where('state_type_id',"!=","11")
         ->OrderBy('user_id','asc');
         if($user_id){
            $sale_notes=$sale_notes->where('user_id',$user_id);
        } 
        if($establishment_id){
            $sale_notes=$sale_notes->where('establishment_id',$establishment_id);
        }
         $documents = Document::query()
         ->with(['items', 'items.m_item'])
         ->select('id','series','number','date_of_issue','state_type_id','customer','document_type_id','user_id','establishment_id')
         ->whereBetween('date_of_issue', [$d_start, $d_end])
         ->where('state_type_id',"!=","11")
         ->OrderBy('user_id','asc');
         if($user_id){
            $documents=$documents->where('user_id',$user_id);
        } 
        if($establishment_id){
            $documents=$documents->where('establishment_id',$establishment_id);
        }
         $records=$sale_notes->union($documents)->get();
         $result=[];
       
         foreach($records as $row) {
            $total_margen = 0;
            $total_quantity=0;
            $item_sale=[];
            $month=substr($request['month_start'],5,2);
            $user=User::where('id',$row->user_id)->first();
                foreach($row->items as $item) {

                    $relation_item = $item->relation_item;
                    if (strtolower($relation_item->is_stock) === 'si') {
                        $price_unit_salenote = $item->unit_price;
                       $purchase_item = DB::connection('tenant')->table('purchase_items')
                       ->join('purchases', 'purchases.id', '=', 'purchase_items.purchase_id')   
                       ->select('purchase_items.item_id','purchase_items.unit_price','purchases.includes')
                       ->whereMonth('purchases.date_of_issue',$month)
                       ->where('purchase_items.item_id',$item->item_id)->get()->last();
                       if( $purchase_item!=null){
                           $incluye_igv=$purchase_item->includes;
                           if($incluye_igv==0){
                                $price_unit_purchase = round(($purchase_item->unit_price*1.18),2);
                           }else{
                                $price_unit_purchase = round(($purchase_item->unit_price),2);
                           }
                      }else{
                        $purchase_itemss = DB::connection('tenant')->table('purchase_items')
                       ->join('purchases', 'purchases.id', '=', 'purchase_items.purchase_id')   
                       ->select('item_id','unit_price','includes')
                       ->whereMonth('purchases.date_of_issue', str_pad($month-1, 2, "0", STR_PAD_LEFT))
                       ->where('purchase_items.item_id',$item->item_id);
                       //->get()->last();
                        if($purchase_itemss->count()>0){
                            $purchase_itemss=$purchase_itemss->get()->last();
                            $incluye_igv=$purchase_itemss->includes;
                           if($incluye_igv==0){
                                $price_unit_purchase = round(($purchase_itemss->unit_price*1.18),2);
                          }else{
                               $price_unit_purchase = round(($purchase_itemss->unit_price),2);
                          }
                        }else{
                           
                            $incluye_igv=0;
                            if($incluye_igv==0){
                                $price_unit_purchase = round(($item->relation_item->purchase_unit_price*1.18),2);
                            }else{
                                $price_unit_purchase = round(($item->relation_item->purchase_unit_price),2);
                            }
                        }
                         
                           //$price_unit_purchase = round(($item->relation_item->purchase_unit_price*1.18),2);
                       }
                        $quantity = $item->quantity;
                        $total_quantity+=$item->quantity;
                        $total_margen += ($price_unit_salenote - $price_unit_purchase) * $quantity;
                        $item_sale[]=[
                        'item_id'=>$item->item->id,
                        'description'=>$item->item->description,
                        'quantity'=>$item->quantity,
                        'purchase_unit_price'=>round($price_unit_purchase,2),
                        'sale_unit_price'=>round($price_unit_salenote,2),
                        'margen' =>round($item->quantity*($price_unit_salenote-$price_unit_purchase),2)
                        ];
                    }
                }
                $result[]=[
                        'id' => $row->id, 
                        'date_of_issue' => $row->date_of_issue->format('d-m-Y'),
                        'document_type' => $row->document_type->id,
                        'document' => $row->document_type->description,
                        'number_full' => $row->series." - ".$row->number,
                        'customer' => $row->customer->name,
                        'user_name' => $user->name,
                        'item'=>$item_sale,
                        'total_margen' =>round($total_margen,2)
                    ];
            }
            $result = collect($result);
          
            $company = Company::first();
            $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;
            if($export=='pdf'){
                 //Exportar a PDF 
              //   return $result;
                
                if($typeresult=='Detallado'){
                    $pdf = PDF::loadView('report::documents.margin_pdf', compact("result","month","mes_consultar","d_month_start","d_month_end","typeresult","date_start", "date_end","company","establishment"))
                    ->setPaper('a4', 'landscape');
                }else{
                    $margin_sales_total=$result->where('document_type','80')->values()->sum('total_margen');
                    $margin_document_total=$result->whereIn('document_type',['01', '03'])->values()->sum('total_margen');
                    $pdf = PDF::loadView('report::documents.margin_pdf', compact("margin_sales_total","margin_document_total","mes_consultar","month","d_month_start","d_month_end","typeresult","date_start", "date_end","company","establishment"))
                    ->setPaper('a5', 'landscape');
                }
                return $pdf->stream();
            }else{
               //Exportar a Excel 
               $margin_sales_total=$result->where('document_type','80')->values()->sum('total_margen');
               $margin_document_total=$result->whereIn('document_type',['01', '03'])->values()->sum('total_margen');
               return (new MarginUtilExport)
               ->result($result)
               ->month($month)
               ->d_month_start($d_month_start)
               ->d_month_end($d_month_end)
               ->typeresult($typeresult)
               ->date_start($date_start)
               ->date_end($date_end)
               ->company($company)
               ->margin_document_total ($margin_document_total)
               ->margin_sales_total ($margin_sales_total)
               ->establishment($establishment)
               
              
               ->download('Reporte_margin_'.Carbon::now().'.xlsx');

            }
        // return new MarginCollection($records->paginate(config('tenant.items_per_page')));

    }
    public function pdf(Request $request) {
        $typeresult=$request['typeresult'];
        
        $company = Company::first();
        $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;
      //  $records = $this->getRecords($request->all(), Document::class)->get();
        //////////////////////////////////////////////////////////////////////////////////////////////////////
        $document_type_id = $request['document_type_id'];
        $establishment_id = $request['establishment_id'];
        $period = $request['period'];        
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $month_start = $request['month_start'];
        $month_end = $request['month_end'];
        $person_id = $request['person_id'];
        $type_person = $request['type_person'];
        $seller_id = $request['seller_id'];
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
                $d_end = $date_end;
                // $d_end = $date_end;
                break;
            case 'between_dates':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
        }

        
        if($document_type_id!=null){
           
            if($document_type_id=="01" || $document_type_id=="03"){
               $documents = DB::connection('tenant')->table('documents')
               ->join('users', 'users.id', '=', 'documents.user_id')         
               ->select("users.name","documents.soap_type_id","documents.document_type_id","documents.state_type_id","documents.date_of_issue","documents.total_exonerated","documents.total_unaffected","documents.total_free","documents.total_taxed","documents.total_igv","documents.total","documents.customer","documents.currency_type_id","documents.series","documents.number",DB::raw("concat(documents.number,' ',documents.series) as number_full"),"total_exportation")
               ->where('document_type_id', 'like', '%' . $document_type_id . '%')
               ->whereBetween('date_of_issue', [$d_start, $d_end])->OrderBy("documents.date_of_issue","asc");
           }else{
               $sale_notes = DB::connection('tenant')->table('sale_notes')
               ->join('users', 'users.id', '=', 'sale_notes.user_id')   
               ->select("users.name","sale_notes.user_id","sale_notes.soap_type_id","sale_notes.document_type_id","sale_notes.state_type_id","sale_notes.date_of_issue","sale_notes.total_exonerated","sale_notes.total_unaffected","sale_notes.total_free","sale_notes.total_taxed","sale_notes.total_igv","sale_notes.total","sale_notes.customer","sale_notes.currency_type_id","sale_notes.series","sale_notes.number",DB::raw("concat(sale_notes.number,' ',sale_notes.series) as number_full"),"sale_notes.total_exportation")
               ->whereBetween('date_of_issue', [$d_start, $d_end])->OrderBy("sale_notes.date_of_issue","asc");
           }       
 
           }elseif($establishment_id){
               
           $documents = DB::connection('tenant')->table('documents')
            ->join('users', 'users.id', '=', 'documents.user_id')          
             ->select("users.name","documents.user_id","documents.soap_type_id","documents.document_type_id","documents.state_type_id","documents.date_of_issue","documents.total_exonerated","documents.total_unaffected","documents.total_free","documents.total_taxed","documents.total_igv","documents.total","documents.customer","documents.currency_type_id","documents.series","documents.number",DB::raw("concat(documents.number,' ',documents.series) as number_full"),"total_exportation")
           ->whereBetween('date_of_issue', [$d_start, $d_end]) 
           ->where('establishment_id', 'like', '%' . $establishment_id . '%')->OrderBy("documents.date_of_issue","asc");

           $sale_notes = DB::connection('tenant')->table('sale_notes')
           ->join('users', 'users.id', '=', 'sale_notes.user_id')   
           ->select("users.name","sale_notes.user_id","sale_notes.user_id","sale_notes.soap_type_id","sale_notes.document_type_id",
           "sale_notes.state_type_id","sale_notes.date_of_issue","sale_notes.total_exonerated","sale_notes.total_unaffected","sale_notes.total_free",
           "sale_notes.total_taxed","sale_notes.total_igv","sale_notes.total","sale_notes.customer","sale_notes.currency_type_id","sale_notes.series",
           "sale_notes.number",DB::raw("concat(sale_notes.number,' ',sale_notes.series) as number_full"),"sale_notes.total_exportation")
           ->whereBetween('date_of_issue', [$d_start, $d_end])
           ->where('establishment_id', 'like', '%' . $establishment_id . '%')->OrderBy("sale_notes.date_of_issue","asc");
       }else{
            $documents = DB::join('users', 'users.id', '=', 'documents.user_id')          
           ->select("users.name","documents.user_id","documents.soap_type_id","documents.document_type_id","documents.state_type_id",
           "documents.date_of_issue","documents.total_exonerated","documents.total_unaffected","documents.total_free","documents.total_taxed",
           "documents.total_igv","documents.total","documents.customer","documents.currency_type_id","documents.series","documents.number",
           DB::raw("concat(documents.number,' ',documents.series) as number_full"),"total_exportation")
           ->whereBetween('date_of_issue', [$d_start, $d_end])->OrderBy("documents.date_of_issue","asc");
       
           $sale_notes = DB::connection('tenant')->table('sale_notes')
           ->join('users', 'users.id', '=', 'sale_notes.user_id')   
           ->select("users.name","sale_notes.user_id","sale_notes.soap_type_id","sale_notes.document_type_id","sale_notes.state_type_id","sale_notes.date_of_issue",
           "sale_notes.total_exonerated","sale_notes.total_unaffected","sale_notes.total_free","sale_notes.total_taxed","sale_notes.total_igv","sale_notes.total",
           "sale_notes.customer","sale_notes.currency_type_id","sale_notes.series","sale_notes.number",
           DB::raw("concat(sale_notes.number,' ',sale_notes.series) as number_full"),"sale_notes.total_exportation")
           ->whereBetween('date_of_issue', [$d_start, $d_end])->OrderBy("sale_notes.date_of_issue","asc");
       }
          if($person_id && $type_person){
             $column = ($type_person == 'customers') ? 'customer_id':'supplier_id';
             if($document_type_id=="01" || $document_type_id=="03"){
                 $documents =  $documents->where($column, $person_id);
            } 
            if($document_type_id=="80"){
                 $sale_notes =  $sale_notes->where($column, $person_id);
            } 
            if($document_type_id==null){
                $sale_notes =  $sale_notes->where($column, $person_id);
                $documents =  $documents->where($column, $person_id);
            }
        }
        
        if($seller_id!=null)
        {
            if($document_type_id=="01" || $document_type_id=="03"){
            $documents =  $documents->where('user_id', $seller_id);
            }
            if($document_type_id=="80"){
            $sale_notes =  $sale_notes->where('user_id', $seller_id);
            }
            if($document_type_id==null){
                $sale_notes =  $sale_notes->where('user_id', $seller_id);
                $documents =  $documents->where('user_id', $seller_id);
            }
            
        }
     
        $resumen_document=[];
        $resumen_documents_result=[];
        $resumen_sale_notes_result=[];
        if($typeresult=="Resumen"){
            $status="02";
            $resumen_sale_notes_result=[];
            if($document_type_id=="80"){
                if($seller_id!=null){
                    $users_list=User::where("id",$seller_id)->OrderBy('id','asc')->get();
                }else{
                    $users_list=User::all();
                }
                foreach ($users_list as $key => $user_row) {
                    $filtrar=$sale_notes->get();
                    $resumen_sale_notes['id']=$user_row->id;
                    $resumen_sale_notes['name']=$user_row->name;
                    $sumas=$filtrar->where("user_id",$user_row->id)->sum("total");
                    $resumen_sale_notes['total']=$sumas;
                    array_push($resumen_sale_notes_result, $resumen_sale_notes);
                }
             //    $documents=$resumen_sale_notes_result;
              
             }else if($document_type_id=="01" || $document_type_id=="03"){
                if($seller_id!=null){
                    $users_list=User::where("id",$seller_id)->OrderBy('id','asc')->get();
                }else{
                    $users_list=User::all();
                }
                foreach ($users_list as $key => $user_row) {
                    $filtrar=$documents->get();
                    $resumen_sale_notes['id']=$user_row->id;
                    $resumen_sale_notes['name']=$user_row->name;
                    $sumas=$filtrar->where("user_id",$user_row->id)->sum("total");
                    $resumen_sale_notes['total']=$sumas;
                    array_push($resumen_documents_result, $resumen_sale_notes);
               
                }
               $documents=$resumen_sale_notes_result;
            }else if($document_type_id==null){
                if($seller_id!=null){
                    $users_list=User::where("id",$seller_id)->OrderBy('id','asc')->get();
                }else{
                    $users_list=User::all();
                }
                $resumen_sale_notes=[];
                foreach ($users_list as $key => $user_row) {
                    $filtrar=$sale_notes->get();
                    $resumen_sale_notes['id']=$user_row->id;
                    $resumen_sale_notes['name']=$user_row->name;
                    $sumas=$filtrar->where("user_id",$user_row->id)->sum("total");
                    $resumen_sale_notes['total']=$sumas;
                    array_push($resumen_sale_notes_result, $resumen_sale_notes);
               
                }
                 //dd($resumen_sale_notes_result);
                $resumen_documents=[];
                if($seller_id!=null){
                    $users_list=User::where("id",$seller_id)->OrderBy('id','asc')->get();
                }else{
                    $users_list=User::all();
                }
                foreach ($users_list as $key => $user_row) {
                     $filtrar=$documents->get();
                    $resumen_documents['id']=$user_row->id;
                    $resumen_documents['name']=$user_row->name;
                    $suma=$filtrar->where("user_id",$user_row->id)->sum("total");
                    $resumen_documents['total']=$suma;
                    array_push($resumen_documents_result, $resumen_documents);
                 }             
                 //dd($resumen_sale_notes_result,$resumen_documents_result);
            }           
        }else{
            $status="01";
            if($document_type_id=="80"){
                $documents=$sale_notes->get();
             }else if($document_type_id!=null && $document_type_id!="80"){
                $documents=$documents->get();
            }else if($sale_notes->count()>0 || $documents->count()>0){
                $documents=$documents->union($sale_notes)->get();
            }else{
                $documents=[];
            }
            $documents= new SaleNotesCollection($documents);
        }
        $pdf = PDF::loadView('report::documents.report_pdf', compact("company","status","resumen_sale_notes_result","resumen_documents_result","establishment","documents","date_start", "date_end"))->setPaper('a4', 'landscape');
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        $filename = 'Reporte_Ventas_'.date('YmdHis');
        return $pdf->stream($filename.'.pdf');
    
    }




    public function excel(Request $request) {
        $typeresult=$request['typeresult'];
        
        $company = Company::first();
        $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;
      //  $records = $this->getRecords($request->all(), Document::class)->get();
        //////////////////////////////////////////////////////////////////////////////////////////////////////
        $document_type_id = $request['document_type_id'];
        $establishment_id = $request['establishment_id'];
        $period = $request['period'];        
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $month_start = $request['month_start'];
        $month_end = $request['month_end'];
        $person_id = $request['person_id'];
        $type_person = $request['type_person'];
        $seller_id = $request['seller_id'];
        $d_start = null;
        $d_end = null;

        switch ($period) {
            case 'month':
                $d_start = Carbon::parse($month_start.'-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_end.'-01')->endOfMonth()->format('Y-m-d');
                // $d_end = Carbon::parse($month_end.'-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'between_months':
                $d_start = Carbon::parse($month_start.'-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_end.'-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'date':
                $d_start = $date_start;
                $d_end = $date_end;
                // $d_end = $date_end;
                break;
            case 'between_dates':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
        }

        
        if($document_type_id!=null){
           
            if($document_type_id=="01" || $document_type_id=="03"){
               $documents = DB::connection('tenant')->table('documents')
               ->join('users', 'users.id', '=', 'documents.user_id')          
               ->select("users.name","documents.soap_type_id","documents.document_type_id","documents.state_type_id","documents.date_of_issue","documents.total_exonerated","documents.total_unaffected","documents.total_free","documents.total_taxed","documents.total_igv","documents.total","documents.customer","documents.currency_type_id","documents.series","documents.number",DB::raw("concat(documents.number,' ',documents.series) as number_full"),"total_exportation")
               ->where('document_type_id', 'like', '%' . $document_type_id . '%')
               ->whereBetween('date_of_issue', [$date_start, $date_end])->OrderBy("documents.date_of_issue","asc");
           }else{
               $sale_notes = DB::connection('tenant')->table('sale_notes')
               ->join('users', 'users.id', '=', 'sale_notes.user_id')   
               ->select("users.name","sale_notes.user_id","sale_notes.soap_type_id","sale_notes.document_type_id","sale_notes.state_type_id","sale_notes.date_of_issue","sale_notes.total_exonerated","sale_notes.total_unaffected","sale_notes.total_free","sale_notes.total_taxed","sale_notes.total_igv","sale_notes.total","sale_notes.customer","sale_notes.currency_type_id","sale_notes.series","sale_notes.number",DB::raw("concat(sale_notes.number,' ',sale_notes.series) as number_full"),"sale_notes.total_exportation")
               ->whereBetween('date_of_issue', [$date_start, $date_end])->OrderBy("sale_notes.date_of_issue","asc");
           }       
 
           }elseif($establishment_id){
               
           $documents = DB::connection('tenant')->table('documents')
            ->join('users', 'users.id', '=', 'documents.user_id')          
             ->select("users.name","documents.user_id","documents.soap_type_id","documents.document_type_id","documents.state_type_id","documents.date_of_issue","documents.total_exonerated","documents.total_unaffected","documents.total_free","documents.total_taxed","documents.total_igv","documents.total","documents.customer","documents.currency_type_id","documents.series","documents.number",DB::raw("concat(documents.number,' ',documents.series) as number_full"),"total_exportation")
           ->whereBetween('date_of_issue', [$date_start, $date_end]) 
           ->where('establishment_id', 'like', '%' . $establishment_id . '%')->OrderBy("documents.date_of_issue","asc");

           $sale_notes = DB::connection('tenant')->table('sale_notes')
           ->join('users', 'users.id', '=', 'sale_notes.user_id')   
           ->select("users.name","sale_notes.user_id","sale_notes.user_id","sale_notes.soap_type_id","sale_notes.document_type_id",
           "sale_notes.state_type_id","sale_notes.date_of_issue","sale_notes.total_exonerated","sale_notes.total_unaffected","sale_notes.total_free",
           "sale_notes.total_taxed","sale_notes.total_igv","sale_notes.total","sale_notes.customer","sale_notes.currency_type_id","sale_notes.series",
           "sale_notes.number",DB::raw("concat(sale_notes.number,' ',sale_notes.series) as number_full"),"sale_notes.total_exportation")
           ->whereBetween('date_of_issue', [$date_start, $date_end])
           ->where('establishment_id', 'like', '%' . $establishment_id . '%')->OrderBy("sale_notes.date_of_issue","asc");
       }else{
            $documents = DB::connection('tenant')->table('documents')
           ->join('users', 'users.id', '=', 'documents.user_id')          
           ->select("users.name","documents.user_id","documents.soap_type_id","documents.document_type_id","documents.state_type_id",
           "documents.date_of_issue","documents.total_exonerated","documents.total_unaffected","documents.total_free","documents.total_taxed",
           "documents.total_igv","documents.total","documents.customer","documents.currency_type_id","documents.series","documents.number",
           DB::raw("concat(documents.number,' ',documents.series) as number_full"),"total_exportation")
           ->whereBetween('date_of_issue', [$date_start, $date_end])->OrderBy("documents.date_of_issue","asc");
       
           $sale_notes = DB::connection('tenant')->table('sale_notes')
           ->join('users', 'users.id', '=', 'sale_notes.user_id')   
           ->select("users.name","sale_notes.user_id","sale_notes.soap_type_id","sale_notes.document_type_id","sale_notes.state_type_id","sale_notes.date_of_issue",
           "sale_notes.total_exonerated","sale_notes.total_unaffected","sale_notes.total_free","sale_notes.total_taxed","sale_notes.total_igv","sale_notes.total",
           "sale_notes.customer","sale_notes.currency_type_id","sale_notes.series","sale_notes.number",
           DB::raw("concat(sale_notes.number,' ',sale_notes.series) as number_full"),"sale_notes.total_exportation")
           ->whereBetween('date_of_issue', [$date_start, $date_end])->OrderBy("sale_notes.date_of_issue","asc");
       }
          if($person_id && $type_person){
             $column = ($type_person == 'customers') ? 'customer_id':'supplier_id';
             if($document_type_id=="01" || $document_type_id=="03"){
                 $documents =  $documents->where($column, $person_id);
            } 
            if($document_type_id=="80"){
                 $sale_notes =  $sale_notes->where($column, $person_id);
            } 
            if($document_type_id==null){
                $sale_notes =  $sale_notes->where($column, $person_id);
                $documents =  $documents->where($column, $person_id);
            }
        }
        
        if($seller_id!=null)
        {
            if($document_type_id=="01" || $document_type_id=="03"){
            $documents =  $documents->where('user_id', $seller_id);
            }
            if($document_type_id=="80"){
            $sale_notes =  $sale_notes->where('user_id', $seller_id);
            }
            if($document_type_id==null){
                $sale_notes =  $sale_notes->where('user_id', $seller_id);
                $documents =  $documents->where('user_id', $seller_id);
            }
            
        }
        $resumen_document=[];
        if($typeresult=="Resumen"){
            $status="02";
            $resumen_sale_notes_result=[];
            $resumen_documents_result=[];
          
            if($document_type_id=="80"){
                if($seller_id!=null){
                    $users_list=User::where("id",$seller_id)->OrderBy('id','asc')->get();
                }else{
                    $users_list=User::all();
                }
                foreach ($users_list as $key => $user_row) {
                    $filtrar=$sale_notes->get();
                    $resumen_sale_notes['id']=$user_row->id;
                    $resumen_sale_notes['name']=$user_row->name;
                    $sumas=$filtrar->where("user_id",$user_row->id)->sum("total");
                    $resumen_sale_notes['total']=$sumas;
                    array_push($resumen_sale_notes_result, $resumen_sale_notes);
                }
                 $documents=$resumen_sale_notes_result;
              
             }else if($document_type_id=="01" || $document_type_id=="03"){
                if($seller_id!=null){
                    $users_list=User::where("id",$seller_id)->OrderBy('id','asc')->get();
                }else{
                    $users_list=User::all();
                }
                foreach ($users_list as $key => $user_row) {
                     
                    $filtrar=$documents->get();
                    $resumen_sale_notes['id']=$user_row->id;
                    $resumen_sale_notes['name']=$user_row->name;
                    $sumas=$filtrar->where("user_id",$user_row->id)->sum("total");
                    $resumen_sale_notes['total']=$sumas;
                    array_push($resumen_documents_result, $resumen_sale_notes);
               
                }
             
             
               $documents=$resumen_sale_notes_result;
            }else if($document_type_id==null){
                if($seller_id!=null){
                    $users_list=User::where("id",$seller_id)->OrderBy('id','asc')->get();
                }else{
                    $users_list=User::all();
                }
                $resumen_sale_notes=[];
                foreach ($users_list as $key => $user_row) {
                    $filtrar=$sale_notes->get();
                    $resumen_sale_notes['id']=$user_row->id;
                    $resumen_sale_notes['name']=$user_row->name;
                    $sumas=$filtrar->where("user_id",$user_row->id)->sum("total");
                 
                    $resumen_sale_notes['total']=$sumas;
                    array_push($resumen_sale_notes_result, $resumen_sale_notes);
               
                }
                 //dd($resumen_sale_notes_result);
                $resumen_documents=[];
                if($seller_id!=null){
                    $users_list=User::where("id",$seller_id)->OrderBy('id','asc')->get();
                }else{
                    $users_list=User::all();
                }
                foreach ($users_list as $key => $user_row) {
                     $filtrar=$documents->get();
                    $resumen_documents['id']=$user_row->id;
                    $resumen_documents['name']=$user_row->name;
                    $suma=$filtrar->where("user_id",$user_row->id)->sum("total");
                    $resumen_documents['total']=$suma;
                    array_push($resumen_documents_result, $resumen_documents);
                 }
             
                 //dd($resumen_sale_notes_result,$resumen_documents_result);
            }
            $record_documents=$resumen_documents_result;
            $sales_records=$resumen_sale_notes_result;
           
        }else{
            $status="01";
            if($document_type_id=="80"){
                $documents=$sale_notes->get();
             }else if($document_type_id!=null && $document_type_id!="80"){
                $documents=$documents->get();
            }else if($sale_notes->count()>0 || $documents->count()>0){
                $documents=$documents->union($sale_notes)->get();
            }else{
                $documents=[];
            }
            $records=$documents;
             $record_documents=[];
            $sales_records=[];

         //   $documents= new SaleNotesCollection($documents);
            
        }
        return (new DocumentExport)
                ->record_documents($record_documents)
                ->sales_records($sales_records)
                ->records($records)
                ->company($company)
                ->status ($status)
                ->establishment($establishment)
                ->date_start($date_start)
                ->date_end($date_end)
               
                ->download('Reporte_Ventas_'.Carbon::now().'.xlsx');

    }
}
