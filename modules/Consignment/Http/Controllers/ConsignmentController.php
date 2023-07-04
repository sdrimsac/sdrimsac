<?php

namespace Modules\Consignment\Http\Controllers;

use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\Person;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Consignment\Http\Resources\ConsignmentCollection;
use Modules\Consignment\Models\Consignment;
use Modules\Consignment\Models\ConsignmentItem;
use Modules\Consignment\Models\ConsignmentItemLot;
use Modules\Consignment\Models\ConsignmentPenalty;
use Modules\Item\Models\ItemLot;

class ConsignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $configuration = Configuration::first();
        return view(
            'consignment::index',
            compact('configuration')
            
        );
    }
    public function stock(Request $request){
        $establishment_id = $request->input('establishment_id');
        $item_id = $request->input('item_id');

        if(!$establishment_id || !$item_id){
            return [
                'stock' => 0,
                'success' => false,
                'message' => 'No se encontró el establecimiento o el producto'
            ];
        }
        // $item = Item::find($item_id);
        $warehouse = ItemWarehouse::where('item_id',$item_id)
            ->where('warehouse_id',$establishment_id)
            ->first();
        if(!$warehouse){
            return [
                'stock' => 0,
                'success' => false,
                'message' => 'No se encontró el almacén'
            ];
        }
            
         $stock =  $warehouse->stock;
        
        return [
            'stock' => $stock,
            'success' => true,
            'message' => 'Stock obtenido con éxito'
        ];

    }
    public function columns()
    {
        return [
            'person_id' => 'Cliente / Vendedor',
            'date_of_issue' => 'Fecha de emisión',
            'date_of_end' => 'Fecha de liquidación'
        ];
    }
    public function records(){
        $consigments = Consignment::query();

        return new ConsignmentCollection($consigments->paginate(config('tenant.items_per_page')) );

    }
    public function tables(){
        $customers = $this->getCustomers();
        $penalties = ConsignmentPenalty::all();
        $items = Item::query()->get()->take(20);
        $establishments = Establishment::all();
        return compact('penalties','customers','items','establishments');
    }
    public function getCustomers(){
        return Person::whereType('customers')->get()->take(20);
    }
    function restoreStock($consigment_id){
        $consigment_items = ConsignmentItem::where('consignment_id',$consigment_id)->get();
        foreach($consigment_items as $consigment_item){
            $item_id = $consigment_item->item_id;
            $establishment_id = $consigment_item->establishment_id;
            $original_quantity = $consigment_item->original_quantity;
            $consigment_item_lots = ConsignmentItemLot::where('consignment_item_id',$consigment_item->id)->get();
            foreach($consigment_item_lots as $consigment_item_lot){
                $series = $consigment_item_lot->series;
                ItemLot::where('item_id',$item_id)
                    ->where('series',$series)
                    ->update([
                        'has_sale' => false,
                    ]);
            }
            $item = Item::find($item_id);
            $item->stock += $original_quantity;
            $item->save();
            $warehouse = ItemWarehouse::where('item_id',$item_id)
                ->where('warehouse_id',$establishment_id)
                ->first();
            $warehouse->stock += $original_quantity;
            $warehouse->save();
        }
    }
    public function store(Request $request){

        // dump($request->all());
        try{
            DB::connection('tenant')->beginTransaction();
            $id = $request->input('id');
            $person_id = $request->input('person_id');
            $date_of_issue = $request->input('date_of_issue');
            $date_of_issue = Carbon::parse($date_of_issue)->format('Y-m-d');
            $date_of_end = $request->input('date_of_end');
            $date_of_end = Carbon::parse($date_of_end)->format('Y-m-d');
            $penalty_id = $request->input('penalty_id');
            $consigment = Consignment::firstOrNew(["id"=>$id]);
            $consigment->person_id = $person_id;
            $consigment->date_of_issue = $date_of_issue;
            $consigment->date_of_end = $date_of_end;
            $consigment->penalty_id = $penalty_id;
            $consigment->save();
            $this->restoreStock($consigment->id);
            $items = $request->input('items');
            foreach($items as $item){
                $consigment_item = new ConsignmentItem();
                $consigment_item->consignment_id = $consigment->id;
                $consigment_item->establishment_id = $item['establishment_id'];
                $consigment_item->item_id = $item['id'];
                $consigment_item->original_quantity = $item['quantity'];
                $consigment_item->price = $item['price'];
                $consigment_item->save();
                $item_id = $item['id'];
                $establishment_id = $item['establishment_id'];
                $original_quantity = $item['quantity'];
                $general_item = Item::find($item_id);
                $general_item->stock -= $original_quantity;
                $general_item->save();
                $warehouse = ItemWarehouse::where('item_id',$item_id)
                    ->where('warehouse_id',$establishment_id)
                    ->first();
                $warehouse->stock -= $original_quantity;
                $warehouse->save();
                $has_lots = $item['has_lots'];
                // dump($item);
                if($has_lots){
                    $lots = $item['lots'];
                    foreach($lots as $lot){
                        $series = $lot['series'];
                        $consigment_item_lot = new ConsignmentItemLot();
                        $consigment_item_lot->consignment_item_id = $consigment_item->id;
                        $consigment_item_lot->series = $series;
                        //agrega el timestamp

                        $consigment_item_lot->save();
                        ItemLot::where('item_id',$item_id)
                            ->where('series',$series)
                            ->update([
                                'has_sale' => true,
                            ]);
                    }
                }
           
            }
    
            DB::connection('tenant')->commit();
    
            return [
                'success' => true,
                'message' => 'Consignación registrada con éxito'
            ];
        }catch(Exception $e){
            DB::connection('tenant')->rollBack();
            return [
                'success' => false,
                'message' => 'Ocurrió un error al registrar la consignación',
                'error' => $e->getMessage()
            ];
        }
    }
    public function items($consigment_id){
        $items = ConsignmentItem::where('consignment_id',$consigment_id)->get()
        ->transform(function ($row){

            return [
                'id' => $row->id,
                'name' => $row->item->description,
                'quantity' => $row->original_quantity,
                'price' => $row->price,
                'total' => $row->original_quantity * $row->price,
                'has_lots' => (bool)$row->item->series_enabled,
            ];
        })
        ;
        
        return [
            'success' => true,
            'items' => $items
        ];
    }
}
