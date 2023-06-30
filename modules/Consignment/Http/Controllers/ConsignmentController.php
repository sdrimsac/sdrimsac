<?php

namespace Modules\Consignment\Http\Controllers;

use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\Person;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Consignment\Http\Resources\ConsignmentCollection;
use Modules\Consignment\Models\Consignment;
use Modules\Consignment\Models\ConsignmentPenalty;

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
        $item = Item::find($item_id);
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
    public function store(){}
    public function items(){}
}
