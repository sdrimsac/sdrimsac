<?php

namespace App\Http\Controllers\Tenant;

use App\CoreFacturalo\Requests\Inputs\Functions;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\CreditListCollection;
use App\Models\Tenant\CreditList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\OrdenItem;
use Modules\Restaurant\Models\Table;

class CreditListController extends Controller
{
   
    public function send_credit(Request $request){
        $customer_id = $request->customer_id;
        $items = $request->items;
        $user_id = auth()->id();
        $table_caja_id = Table::get_caja();
        $status_orden_id = 4;
        $orden = Orden::create([
            'table_id' => $table_caja_id,
            'status_orden_id' => $status_orden_id,
            'date' => date('Y-m-d'),
        ]);
        foreach ($items as $item) {
            $orden_item = new OrdenItem;
            $orden_item->food_id = $item['food']['id'];
            $orden_item->observations = $item['observation'] ?? '-';
            $orden_item->quantity = $item['quantity'];
            $orden_item->unit_type_id = Functions::valueKeyInArray($item, 'type_id', null);
            $orden_item->price = $item['price'];
            $orden_item->user_id = $user_id;
            $orden_item->orden_id = $orden->id;
            $orden_item->to_carry = Functions::valueKeyInArray($item, 'to_carry', 0);
            $orden_item->status_orden_id = 1;
            $orden_item->date = Carbon::today();
            $orden_item->time = date('H:i:s');
            $orden_item->area_id = $item['food']['area_id'];
            $orden_item->save();
        
        }

        CreditList::create([
            'orden_id' => $orden->id,
            'customer_id' => $customer_id,
            'user_id' => $user_id,
            'establishment_id' => auth()->user()->establishment_id,
            'observation' => $request->observation,
            'paid' => false,
        ]);

        return [
            'success' => true,
            'message' => 'Credito enviado correctamente'
        ];
        // $orden_id = $request->orden_id;
    }
    public function records(){
        //saca los registros que tengan paid en false pero agrupados por customer_id
        $credit_lists = CreditList::select('customer_id', \DB::raw('count(*) as count'))
        ->where('paid', false)
        ->groupBy('customer_id');

        return new CreditListCollection($credit_lists->paginate(config('tenant.items_per_page')));
    }
    public function get_ordens($customer_id){
        $credit_lists = CreditList::where('customer_id', $customer_id)
        ->where('paid', false)
        ->with(['orden.orden_items'])
        ->get()
        ->flatMap(function ($creditList) {
            return $creditList->orden->orden_items->map(function ($ordenItem) {
                return [
                    'id' => $ordenItem->id,
                    'food' => $ordenItem->food,
                    'observations' => $ordenItem->observations,
                    'quantity' => $ordenItem->quantity,
                    'unit_type_id' => $ordenItem->unit_type_id,
                    'price' => $ordenItem->price,
                    'user_id' => $ordenItem->user_id,
                    'orden_id' => $ordenItem->orden_id,
                    'to_carry' => $ordenItem->to_carry,
                    'status_orden_id' => $ordenItem->status_orden_id,
                    'date' => $ordenItem->date,
                    'time' => $ordenItem->time,
                    'area_id' => $ordenItem->area_id,
                ];
            });
        });

        return $credit_lists;

    }
    public function get_balance($customer_id)
    {
        $balance = CreditList::where('customer_id', $customer_id)
            ->where('paid', false)
            ->with(['orden.orden_items'])
            ->get()
            ->flatMap(function ($creditList) {
                return $creditList->orden->orden_items->map(function ($ordenItem) {
                    return $ordenItem->quantity * $ordenItem->price;
                });
            })
            ->sum();
    
        return $balance;
    }
    
}
