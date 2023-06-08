<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Resources\Tenant\ConsolidatedCollection;
use App\Http\Resources\Tenant\DocumentResource;
use Modules\Order\Models\OrderNote;
//use Modules\Order\Models\OrderNoteItem;
use App\Models\Tenant\Item;
use App\Models\Tenant\Document;
use App\Models\Tenant\DocumentItem;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\SaleNoteItem;
use App\Models\Tenant\Establishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Modules\Report\Traits\ReportTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
class ConsolidatedController extends Controller
{
    use ReportTrait;

    public function __construct()
    {
        // $this->middleware('input.request:document,web', ['only' => ['store']]);
    }
    public function index(){
        //return view('report::sales_consolidated.index');
        return view('tenant.salesconsolidated.index');
    }
    public function filter() {

        $establishment = Establishment::where('id',auth()->user()->establishment_id)->first();
        $persons = $this->getPersons('customers');
        $date_range_types = $this->getDateRangeTypes(true);
        $order_state_types = [];
        $sellers = $this->getSellers();
        $document_types = $this->getCIDocumentTypes();

        return compact('persons', 'date_range_types', 'order_state_types', 'sellers', 'document_types','establishment');
    }
    public function records(Request $request){
         //Resultado de Pedidos
        $array_items=[];
        $array_balance=[];
        $notaventa_array=[];
        $items=[];
        $orders = OrderNote::whereBetween('date_of_issue', [$request->date_start,$request->date_end])->get();
            foreach ($orders as $row){
                foreach ($row->items as $rows_items) {
                    $items[]=array('item_id'=>$rows_items->item_id,'description'=>$rows_items->item->full_description,'quantity'=>intval(OrderNoteItem::where('item_id',$rows_items->item_id)->sum('quantity')),'unit_price'=>number_format($rows_items->unit_price,2),'total'=>number_format(($rows_items->unit_price*OrderNoteItem::where('item_id',$rows_items->item_id)->sum('quantity')),2));
                   if(count($array_balance)==0){
                        if(array_search($rows_items->item_id, array_column($array_items,'item_id'))===false){
                            array_push($array_balance,array('item_id'=>$rows_items->item_id,'description'=>$rows_items->item->full_description,'quantity'=>0));
                        }
                   }else{
                        if(array_search($rows_items->item_id, array_column($array_balance,'item_id'))===false){
                            array_push($array_balance,array('item_id'=>$rows_items->item_id,'description'=>$rows_items->item->full_description,'quantity'=>0));
                        }
                   }
                };
            }
         if(count($items)>0){
            array_push($array_items,$items);
            $pedidos=collect($array_items[0])->unique('item_id');
         }else{
            $pedidos=[];
         }

        //Resultado de Nota de Venta
        $array_items2=[];
        $notas=[];
        $sale = SaleNote::whereBetween('date_of_issue', [$request->date_start,$request->date_end])->where('user_id',$request->seller_id)->get();
        foreach ($sale as $row){
            foreach ($row->items as $rows_items) {
                $notas[]=array('item_id'=>$rows_items->item_id,'description'=>$rows_items->item->full_description,'quantity'=>intval(SaleNoteItem::where('item_id',$rows_items->item_id)->sum('quantity')),'unit_price'=>number_format($rows_items->unit_price,2),'total'=>number_format(($rows_items->unit_price*OrderNoteItem::where('item_id',$rows_items->item_id)->sum('quantity')),2));
                if(array_search($rows_items->item_id, array_column($array_balance,'item_id'))===false){
                   array_push($array_balance,array('item_id'=>$rows_items->item_id,'description'=>$rows_items->item->full_description,'quantity'=>0));
                }
            }
        }
        $notes=[];
        if(count($notas)){
            array_push($array_items2,$notas);
            $notes=$array_items2[0];
            $notaventa=collect($notes)->unique('item_id');
            $notaventa_array=$notaventa->toArray();

        }else{
            $notaventa=[];
        }


        //Resultado de Boleta de Venta - Factura
       $array_items3=[];
       $sales=[];
       $sale = Document::whereBetween('date_of_issue', [$request->date_start,$request->date_end])->where('user_id',$request->seller_id)->get();
        foreach ($sale as $row){
            foreach ($row->items as $rows_itemss) {
                $sales[]=array('item_id'=>$rows_itemss->item_id,'description'=>$rows_itemss->item->description,'quantity'=>intval(DocumentItem::where('item_id',$rows_itemss->item_id)->sum('quantity')),'unit_price'=>number_format($rows_itemss->unit_price,2),'total'=>number_format(($rows_itemss->unit_price*DocumentItem::where('item_id',$rows_itemss->item_id)->sum('quantity')),2));
                if(array_search($rows_itemss->item_id, array_column($array_balance,'item_id'))===false){
                    array_push($array_balance,array('item_id'=>$rows_itemss->item_id,'description'=>$rows_itemss->item->description,'quantity'=>0));
                 }
            }
        }
     //dd($array_balance);
     if(count($sales)>0){
        array_push($array_items3,$sales);
        $sales=collect($array_items3[0])->unique('item_id');
        $balances=$array_balance;
        $sales_array=$sales->toArray();
     }else{
        $balances=[];
     }
     //$rows_balances=$balances->toArray();
     if(OrderNote::whereBetween('date_of_issue', [$request->date_start,$request->date_end])->count()>0){
        $pedidos_array=$pedidos->toArray();
     }else{
        $pedidos_array=[];
     }
     $cantidad=0;
     $keyy=-1;
     $cantidad_pedidos=0;
     $cantidad_sales=0;
     $cantidad_nota=0;
     $saldo_item=0;

     foreach ($balances as $row) {
         $keyy++;
        if(array_search($row['item_id'], array_column($pedidos_array,'item_id'))!==false){
            $key=array_search($row['item_id'], array_column($pedidos_array,'item_id'));
            $cantidad_pedidos=$pedidos_array[$key]['quantity'];
        }
        if(array_search($row['item_id'], array_column($notaventa_array,'item_id'))!==false){
            $key=array_search($row['item_id'], array_column($notaventa_array,'item_id'));
            $cantidad_nota=$notaventa_array[$key]['quantity'];
            $saldo_item=$cantidad_pedidos-$cantidad_nota;
        }
        if(array_search($row['item_id'], array_column($sales_array,'item_id'))!==false){
            $key=array_search($row['item_id'], array_column($sales_array,'item_id'));
            $cantidad_sales=$sales_array[$key]['quantity'];
            $saldo_item=($cantidad_nota+$cantidad_sales)-$cantidad_pedidos;
        }

       $balances[$keyy]['quantity'] = $saldo_item;
       $saldo_item=0;
     }
     return compact('pedidos','notaventa','sales','balances');
     }



}
