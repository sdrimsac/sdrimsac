<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
//use Illuminate\Support\Str;
//use App\Http\Requests\Tenant\OrderRequest;
use App\Http\Resources\Tenant\OrderCollection;
use Exception;
use Illuminate\Http\Request;
use App\Models\Tenant\Order;
use App\Models\Tenant\ItemWarehouse;
use App\Http\Resources\Tenant\ItemWarehouseCollection;
use App\Http\Resources\Tenant\OrderResource;

class OrderController extends Controller
{
    public function index()
    {
        return view('tenant.orders.index');
    }

    public function columns()
    {
        return [
            'id' => 'Codigo de Pedido',
            'number_document' => 'Comprobante Electronico',
        ];
    }
   
    public function record($id)
    {
      $records = Order::where('id', '=', $id)->latest();
      return new OrderCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function update(Request $request){
      $order = Order::findOrFail($request->id);
      $order->items=$request->items;
      $order->save();
      return [
        'success' => true,
        'message' => 'Se Actualizó con exito',
        'data' =>  $order,
    ];
    }
    public function records(Request $request)
    {
        $records = Order::where($request->column, 'like', "%{$request->value}%")->latest();
        return new OrderCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function StatusOrders(Request $request){
   //   dd($request->all());
      $order=Order::findOrFail($request->id);
      //return $record;
      $order->document_external_id=$request->document_external_id;
      $order->status_order_id=$request->status_order_id;
      $order->number_document=$request->number_document;
      $order->save();
      return [
        'message' => 'Estatus actualizado'
      ];
    }
    public function updateStatusOrders(Request $request)
    {
      
      if ($request->record['status_order_id'] == 3) {
        for ($i=0; $i <= count($request->discount)-1; $i++) {
          if (isset($request->discount[$i]['id'])) {
            $itemWarehouse = ItemWarehouse::where('id', $request->discount[$i]['id'])->first();

            //if ($itemWarehouse->stock >= $request->discount[$i]['cantidad']) {
              ItemWarehouse::where('id', $itemWarehouse->id)->update(['stock' => ($itemWarehouse->stock - $request->discount[$i]['cantidad'])]);

            //}
          }
        }
        Order::where('id', $request->record['id'])->update(['status_order_id' => $request->record['status_order_id']]);

        return [
          'message' => 'Estatus y Stock actualizado'
        ];
      }

      Order::where('id', $request->record['id'])->update(['status_order_id' => $request->record['status_order_id']]);
      return [
        'message' => 'Estatus actualizado'
      ];

    }

    public function searchWarehouse(Request $request)
    {
      $product = ItemWarehouse::whereIn('item_id', $request->item_id)->orderBy('item_id')->get();
      return new ItemWarehouseCollection($product);
    }

}
