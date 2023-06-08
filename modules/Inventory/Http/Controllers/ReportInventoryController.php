<?php

namespace Modules\Inventory\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tenant\Item;
use Illuminate\Http\Request;
use App\Models\Tenant\Company;
use Modules\Item\Models\CategoryItem;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Establishment;
use Modules\Inventory\Models\Warehouse;
use Modules\Inventory\Models\ItemWarehouse;
use Modules\Inventory\Exports\InventoryExport;
use Modules\Inventory\Http\Resources\InventoryCollection;
use Mpdf\Mpdf;
use App\CoreFacturalo\Helpers\Storage\StorageDocument;
class ReportInventoryController extends Controller
{
    use StorageDocument;
    public function __construct()
    {
        ini_set('memory_limit', -1);
    }

    public function index() {
        return view('inventory::reports.inventory.index');
    }
    public function records(Request $request) {
        $category_id=$request->category_id;
        //->paginate(config('tenant.items_per_page'))
      
        if($request->warehouse_id==null  && $request->category_id==null){
         
            $reports = ItemWarehouse::with(['item'])->whereHas('item',function($q){
                $q->where([['item_type_id', '01'], ['unit_type_id', '!=','ZZ']]);
                $q->whereNotIsSet();
            })->latest();
        }else if($request->warehouse_id != null && $request->category_id==null){
            $reports = ItemWarehouse::with(['item'])->where('warehouse_id', $request->warehouse_id)->whereHas('item',function($q){
                $q->where([['item_type_id', '01'], ['unit_type_id', '!=','ZZ']]);
                $q->whereNotIsSet();
            })->latest();
        }else if($request->warehouse_id == null && $request->category_id!=null){
            $reports = ItemWarehouse::with(['item'])->whereHas('item',function($q) use ($category_id){
                $q->with(['category'])->where('category_id', $category_id)->whereHas('category',function($qq){
                })->where([['item_type_id', '01'],['unit_type_id', '!=','ZZ']])->whereNotIsSet();          
               })->latest();    
        }else if($request->warehouse_id != null && $request->category_id!=null){

            $reports = ItemWarehouse::with(['item'])->where('warehouse_id', $request->warehouse_id)->whereHas('item',function($q) use ($category_id){
                $q->with(['category'])->where('category_id', $category_id)->whereHas('category',function($qq){
                })->where([['item_type_id', '01'],['unit_type_id', '!=','ZZ']])->whereNotIsSet();          
            })
            ->latest();    
        }else{
           
            $reports = ItemWarehouse::with(['item'])->whereHas('item',function($q){
                $q->where([['item_type_id', '01'], ['unit_type_id', '!=','ZZ']]);
                $q->whereNotIsSet();
            })->latest();
        }
       
        return new InventoryCollection($reports->paginate(config('tenant.items_per_page')));
      //  return $reports->get();
       // return view('inventory::reports.inventory.index', compact('reports', 'warehouses','categories'));
    }

    /**
     * Search
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function tables(){
        $warehouses = Warehouse::select('id', 'description')->get();
         $categories = CategoryItem::orderBy('name','asc')->get();
        return compact('warehouses','categories');
    }
    public function search(Request $request) {
  
        $reports = ItemWarehouse::with(['item'])->whereHas('item', function($q){
            $q->where([['item_type_id', '01'], ['unit_type_id', '!=','ZZ']]);
            $q->whereNotIsSet();
        })->latest()->get();

        return view('inventory::reports.inventory.index', compact('reports'));
    }

    /**
     * PDF
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function pdf(Request $request) {
        // dd("qqqq    ");
        $category_id=$request->category_id;
        $company = Company::first();
        $establishment = Establishment::first();
       $typeresult=$request->typeresult;

       
      if($category_id==null){
           // $reports = CategoryItem::select('id','name')->get();
            $reports = collect(CategoryItem::select('id','name')->get())->transform(function ($row) use ($request) {
                $items=Item::where('category_id',$row->id)
                ->whereHas('warehouses', function($q) use ($request){
                    if($request->warehouse_id!=null){

                        $q->where('warehouse_id', $request->warehouse_id);
                    }
                })
                ->where([['item_type_id', '01'], ['unit_type_id', '!=','ZZ']])
                ->get();
                return [
                    'id' => $row->id,
                    'name' => $row->name,
                    'item' => $items,

                ];
            });
      
         }
        else{
            //$reports = CategoryItem::select('id','name')->where('id',$category_id)->get();
            $reports = collect(CategoryItem::select('id','name')->where('id',$category_id)->get())->transform(function ($row) use ($request) {
                $items=Item::where('category_id',$row->id)
                ->whereHas('warehouses', function($q) use ($request){
                    if($request->warehouse_id!=null){

                        $q->where('warehouse_id', $request->warehouse_id);
                    }
                })
                ->where([['item_type_id', '01'], ['unit_type_id', '!=','ZZ']])
                ->get();
                return [
                    'id' => $row->id,
                    'name' => $row->name,
                    'item' => $items,
                ];
            });

            //  foreach($reports as $rows){
            //     $items_rows=Item::where('category_id',$category_id)->get();
            //     if($items_rows!=null){
            //         $rows->item=$items_rows;
            //     }
            // }
        }
        $total_utilidad=0;
        ///dd();
        $yy=0;
        $warehouse_id=$request->warehouse_id;
        //dd($items_rows);
      //  return [$reports,$typeresult,$items_rows];
      $pdf = PDF::loadView('inventory::reports.inventory.report_pdf', compact("reports","typeresult", "company", "establishment","warehouse_id"))->setPaper('a4', 'landscape');;
        $filename = 'Reporte_Inventario'.date('YmdHis');
        return $pdf->stream($filename.'.pdf');

     //   $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        // $fontDirs = $defaultConfig['fontDir'];
 
        // $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        // $fontData = $defaultFontConfig['fontdata'];
        // $mpdf = new Mpdf([
        //     'fontDir' => array_merge($fontDirs, [
        //         public_path() . '/fonts',
        //     ]),
          
        //     'default_font' => 'arial',
        //     // "format" => "A4",
        //     "format" => [264.8,188.9],
        // ]);
        // // $mpdf->SetTopMargin(5);
        // $mpdf->SetDisplayMode('fullpage');
        // $mpdf->WriteHTML(view('inventory::reports.inventory.report_pdf', compact("reports","typeresult", "company", "establishment"))->render());
        // $mpdf->Output(storage_path('app/pdf/inventory.pdf'),"F");
     // $this->uploadStorage("inventory",$mpdf->output('', 'S'),'inventory');
        // dd($mpdf);
       
    }

    /**
     * Excel
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function excel(Request $request) {
        $company = Company::first();
        $establishment = Establishment::first();
        $category_id=$request->category_id;
        $typeresult=$request->typeresult;
        if($request->warehouse_id==null  && $request->category_id==null){
            $results = ItemWarehouse::with(['item'])->whereHas('item',function($q){
                $q->where([['item_type_id', '01'], ['unit_type_id', '!=','ZZ']]);
                $q->whereNotIsSet();
            })->latest();
        }else if($request->warehouse_id != null && $request->category_id==null){
            $results = ItemWarehouse::with(['item'])->where('warehouse_id', $request->warehouse_id)->whereHas('item',function($q){
                $q->where([['item_type_id', '01'], ['unit_type_id', '!=','ZZ']]);
                $q->whereNotIsSet();
            })->latest();
        }else if($request->warehouse_id == null && $request->category_id!=null){
            //Aqui
            $results = ItemWarehouse::with(['item'])->whereHas('item',function($q) use ($category_id){
                $q->with(['category'])->where('category_id', $category_id)->whereHas('category',function($qq){
                })->where([['item_type_id', '01'],['unit_type_id', '!=','ZZ']])->whereNotIsSet();          
            })->latest();
        }else if($request->warehouse_id != null && $request->category_id!=null){ 
            //Aqui
            
            $results=ItemWarehouse::with(['item'])->where('warehouse_id',$request->warehouse_id)->whereHas('item',function($q)use($category_id){
                $q->with(['category'])->where('category_id', $category_id)->whereHas('category',function($qq){
                })->where([['item_type_id', '01'],['unit_type_id', '!=','ZZ']])->whereNotIsSet();          
            })->latest();    
        }else{
           
            $results = ItemWarehouse::with(['item'])->whereHas('item',function($q){
                $q->where([['item_type_id', '01'], ['unit_type_id', '!=','ZZ']]);
                $q->whereNotIsSet();
            })->latest();
        }
        if($category_id==null){
            $reports = CategoryItem::select('id','name')->get();
            foreach($reports as $rows){
                $items_rows=Item::where('category_id',$rows->id)
                ->whereHas('warehouses', function($q) use($request){
                    if($request->warehouse_id!=null){
                        $q->where('warehouse_id', $request->warehouse_id);
                    }
                })
                ->where([['item_type_id', '01'], ['unit_type_id', '!=','ZZ']])
                ->get();
                if($items_rows!=null){
                    $rows->item=$items_rows;
                }
            }
        }else{
            $reports = CategoryItem::select('id','name')->where('id',$category_id)->get();
             foreach($reports as $rows){
                $items_rows=Item::where('category_id',$category_id)
                ->whereHas('warehouses', function($q) use($request){
                    if($request->warehouse_id!=null){

                        $q->where('warehouse_id', $request->warehouse_id);
                    }
                })
                ->where([['item_type_id', '01'], ['unit_type_id', '!=','ZZ']])
                ->with(['item_lots'])
                ->get();
                if($items_rows!=null){
                    $rows->item=$items_rows;
                }
            }
        }
     
   
        return (new InventoryExport)
            ->warehouse_id($request->warehouse_id)
            ->records($reports)
            ->typeresult($typeresult)
            ->company($company)
            ->establishment($establishment)
            ->download('ReporteInv'.Carbon::now().'.xlsx');
    }
}
