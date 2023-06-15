<?php

namespace App\Http\Resources\Tenant;
use Carbon\Carbon;
use App\Models\Tenant\User;
use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MarginCollection extends ResourceCollection
{
    
    private $month;
    public function toArray($request)
    {       $result_margin = [];
            $this->month=substr($request['month_start'],5,2);
          
            return $this->collection->transform(function($row, $key) {
                   // $purchase=Purchase::where('date_of_issue',$row->date_of_issue)->first();

                    $total_margen = 0;
                    $total_quantity=0;
                    $item_sale=[];
                    $user=User::where('id',$row->user_id)->first();
                    $number=$row->number;
                    $tipoc=$row->document_type_id;
                   // $month=substr($request['month_start'],5,2);
                    foreach($row->items as $item) {
                        //dd($request->all(), $month);
                        $relation_item = $item->relation_item;
                        if (strtolower($relation_item->is_stock) === 'si') {
                            $price_unit_salenote = $item->unit_price;
                       $purchase_item = DB::connection('tenant')->table('purchase_items')
                       ->join('purchases', 'purchases.id', '=', 'purchase_items.purchase_id')   
                       ->select('purchase_items.item_id','purchase_items.unit_price','purchases.includes')
                       ->whereMonth('purchases.date_of_issue', $this->month)
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
                       ->whereMonth('purchases.date_of_issue', str_pad($this->month-1, 2, "0", STR_PAD_LEFT))
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
                 return [
                'id' => $row->id, 
                'date_of_issue' => $row->date_of_issue->format('d-m-Y'),
                'document' => $row->document_type->description,
                'number_full' => $row->series."-".$row->number,
                'customer' => $row->customer->name,
                'user_name' => $user->name,
                'item'=>$item_sale,
                'total_margen' => number_format($total_margen,2)
            ];
        });
    }
}