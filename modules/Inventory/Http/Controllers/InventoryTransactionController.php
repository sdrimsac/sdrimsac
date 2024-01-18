<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Warehouse;
use Illuminate\Http\Request;
use Modules\Inventory\Http\Resources\InventoryTransactionCollection;
use Modules\Inventory\Models\InventoryTransaction;

class InventoryTransactionController extends Controller
{
    public function index()
    {
        return view('inventory::transactions.index');
    }

    public function columns()
    {
        return [
            'name' => 'Descripción',
            'type' => 'Tipo',
        ];
    }

    public function tables(Request $request){
        $warehouses = Warehouse::all();
        return compact('warehouses');
    }
    public function records(Request $request)
    {
        $records = InventoryTransaction::where($request->column, 'like', "%{$request->value}%")
            ->orderBy('id');

        return new InventoryTransactionCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function record($id)
    {
        return InventoryTransaction::findOrFail($id);
    }

    public function store(Request $request)
    {
        $id = $request->input('id');
        $inventory_transaction = InventoryTransaction::firstOrNew(['id' => $id]);
        $inventory_transaction->fill($request->all());
        if(!$id){
            //obtén el id más alto de la tabla
            $inventory_transaction->id = InventoryTransaction::max('id') + 1;
            
        }
        $inventory_transaction->save();

        return [
            'success' => true,
            'message' => ($id)?'Transacción editada con éxito':'Transacción registrada con éxito'
        ];
    }

    public function delete($id){

        $deleted = InventoryTransaction::where('id', $id)->delete();

        return [
            'success' => true,
            'message' => 'Transacción eliminada con éxito'
        ];


    }
}