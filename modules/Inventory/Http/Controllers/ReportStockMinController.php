<?php

namespace Modules\Inventory\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Tenant\Item;
use Illuminate\Http\Request;
use App\Models\Tenant\Company;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Models\Tenant\Establishment;
use Modules\Inventory\Models\ListOrdenCompra;
use Modules\Inventory\Models\OrdenCompra;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;
use Modules\Report\Exports\StockMinExport;

class ReportStockMinController extends Controller
{
    public function index() {
        $stablecimientos = Establishment::all();
        $categoriaFoods = DB::connection('tenant')->select('select * from categories');
        //$resultArraycategoriaFoods = json_decode(json_encode($categoriaFoods), true);


        return view('inventory::reports.stockmin.index')->with('stablecimientos', $stablecimientos)->with('resultArraycategoriaFoods', $categoriaFoods);
    }

    public function records (Request $request){
        $description = $request->values;
        
        if($description == 'campoVacio'){
            $records= Item::select('items.id', 'items.description','item_warehouse.stock', 'items.stock_min',  'warehouses.description as almacen'  ,'items.has_orden_compra')
            ->join('item_warehouse', 'item_warehouse.item_id','=', 'items.id')
            ->join('warehouses', 'warehouses.id','=', 'item_warehouse.warehouse_id')
            ->whereRaw('item_warehouse.stock <= items.stock_min' )
            ->where('items.has_orden_compra', '=', 0)
            ->orderBy('almacen', 'desc')
            ->orderBy('stock', 'desc')
            ->paginate(10);
        }else{
            $records= Item::select('items.id', 'items.description','item_warehouse.stock', 'items.stock_min',  'warehouses.description as almacen'  ,'items.has_orden_compra')
            ->join('item_warehouse', 'item_warehouse.item_id','=', 'items.id')
            ->join('warehouses', 'warehouses.id','=', 'item_warehouse.warehouse_id')
            ->whereRaw('item_warehouse.stock <= items.stock_min' )
            ->where('items.has_orden_compra', '=', 0)
            ->whereRaw('items.description like "%'.$description.'%"')
            ->orderBy('almacen', 'desc')
            ->orderBy('stock', 'desc')
            ->paginate(10);
        }

        

        
        
        return $records;
    }

    public function recordsProveedor(Request $request){

        $records = DB::connection('tenant')->select('SELECT purchase_items.unit_price, purchase_items.item_id, items.description, persons.id persona_id,     purchases.date_of_issue,    persons.NAME     FROM purchases INNER JOIN purchase_items ON purchases.id = purchase_items.purchase_id INNER JOIN persons ON persons.id = purchases.supplier_id INNER JOIN items ON purchase_items.item_id = items.id     WHERE item_id = ?    ORDER BY item_id, unit_price',[$request->id]) ;
        
        return  $records;
    }
    public function insertAprovisionar(Request $request ){
        $item_id = $request -> item_id ;
        $prov_id = $request -> prov_id ;
        $precio_compra = $request -> precio_compra ;

        //realizamos el insert del producto que vamos a colocar en la orden de compra 
        $ordencompra = ListOrdenCompra::create([
            'item_id' => $item_id,
            'id_persons' => $prov_id,
            'unit_price' => $precio_compra,
            'id_orden_compra' => null ,
            
        ]);
        
        $itemupdate = Item::where('id', $item_id)->first();

        
        $itemupdate->update([
            'has_orden_compra' => 1
        ]);

        return ; 
    }
    public function recordsOrden(){
        $records = DB::connection('tenant')->select('SELECT list_orden_compras.id, persons.`name`, list_orden_compras.unit_price, items.description , item_id,id_orden_compra FROM list_orden_compras INNER JOIN persons ON list_orden_compras.id_persons = persons.id INNER JOIN items ON list_orden_compras.item_id = items.id WHERE ISNULL(id_orden_compra)  ORDER BY persons.NAME, list_orden_compras.id');

         return $records;
    }
    public function deletefromlist(Request $request) {
        $record = ListOrdenCompra::findOrFail($request->id);

        Item::where('id', $record-> item_id )->update(['has_orden_compra'=>0 ]);
        $record->delete();

        return;
    }
    public function genOrdenCompra(Request $request){
        $ordenesCompra = $request->ordenesCompra; 
        $company = Company::find(1);
        
        $montoTotal = 0; 

        try{
           
            DB::beginTransaction();
            
            foreach($ordenesCompra as $key => $value){
                
                $pricListOrden = $value['unit_price'];
                $montoTotal  += $pricListOrden;
            }
            OrdenCompra::create([
                'ordc_total_monto' => $montoTotal ,
                'ordc_status' => 0 ,
            ]);
            

            $numOrdengen  =  DB::connection('tenant')->select('select id from orden_compras  order by 1 DESC limit 1');
            DB::connection('tenant')->update('update list_orden_compras set id_orden_compra = ? WHERE ISNULL(id_orden_compra) ', [$numOrdengen[0]->id ] );

            foreach($ordenesCompra as $key => $value){
                
                $idItem = $value['item_id'];
                DB::connection('tenant')->update('update items set has_orden_compra = 0 where id = ?', [$idItem]);
            }

            DB::commit();
            
            
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
        // generar el excel con la informacion generada 

        
        return $numOrdengen[0]->id ;
    }

    public function exportExcel(Request $request){
        $idOrdCom = $request->id; 
        $ordenesCompra = [];

        $ordenesCompra = ListOrdenCompra::join('items', 'items.id','=', 'list_orden_compras.item_id' )
            ->join('persons', 'persons.id','=', 'id_persons')
            ->where('id_orden_compra',$idOrdCom )->get();
        
        $dataOrdenCompra =  OrdenCompra::where('id', $idOrdCom)->orderBy('id', 'desc')->get()->toArray();
        
        $company = Company::find(1);
        $numOrdengen = $idOrdCom;
        

        $documento = (new StockMinExport)
        ->numOrdengen($numOrdengen)
        ->ordenesCompra($ordenesCompra)
        ->company($company)
        ->sumOrden($dataOrdenCompra)
        ->download('ReporteDoc' . Carbon::now() . '.xlsx');
        
        return $documento ;
    }

    public function listOrdenCompra(Request $request){
        $data =  OrdenCompra::orderBy('id', 'desc')->paginate(10);
        return $data;
    }

    public function productosDetalle(Request $request){
        $data= ListOrdenCompra::join('items', 'items.id','=', 'list_orden_compras.item_id' )
        ->join('persons', 'persons.id','=', 'id_persons')->select('items.description', 'persons.name','id_persons')->where('id_orden_compra',$request->id)->orderBy('id_persons')->get();
        return $data; 
    }
    
    public function getListProv(){
        
       $data = DB::connection('tenant')->select('select * from persons where type = ?', ['suppliers']);
       
        
       return response()->json(['data' => $data]);
    }
    public function genOrdenCompraMasiva(Request $request){
        $data = $request->all();
        $distinc = DB::connection('tenant')->select('	
        SELECT
            DISTINCT(purchase_items.item_id)
        FROM
            purchases
            INNER JOIN purchase_items ON purchases.id = purchase_items.purchase_id 
            INNER JOIN persons ON persons.id = purchases.supplier_id
            INNER JOIN items ON purchase_items.item_id = items.id 
        WHERE
            persons.id = ?  
        
        
            ORDER BY 1 desc ', [$data['prov_id']]);


        $datos = DB::connection('tenant')->select('	
        SELECT
            purchase_items.id,
            purchase_items.unit_price,
            purchase_items.item_id,
            items.description,
            persons.id persona_id,
            purchases.date_of_issue,
            persons.NAME ,
            item_warehouse.stock
        FROM
            purchases
            INNER JOIN purchase_items ON purchases.id = purchase_items.purchase_id 
            INNER JOIN persons ON persons.id = purchases.supplier_id
            INNER JOIN items ON purchase_items.item_id = items.id 
            INNER JOIN item_warehouse ON items.id = item_warehouse.item_id 
        WHERE
            persons.id = ? AND item_warehouse.stock <= items.stock_min  
        
        
            ORDER BY 1 desc ', [$data['prov_id']]);

            $resultados_array = json_decode(json_encode($datos), true);
            $evaluar= json_decode(json_encode($distinc), true); 

        //eliminar los elementos repetidos dentro de la consuolta, elementos que se han tomado en cuenta en compras anteriores 
        
        $newarray = [];
        foreach($evaluar as $key => $value){
            $newarray[] = $value['item_id']; 
        }
        

        $montoTotal = 0 ;
        $consulta = [];
        foreach($newarray as $key => $value){

            foreach($resultados_array as $key2 => $dato)
            if($value == $dato['item_id'] ){
                $consulta[] = $resultados_array[$key2] ; 
                $montoTotal += $dato['unit_price'] ; 
                break ;
            }
        }
            
        try{
           
            DB::beginTransaction();

            $idOrdenCompra = OrdenCompra::create([
                'ordc_total_monto' => $montoTotal ,
                'ordc_status' => 0 ,
            ]);
            

            foreach($consulta as $key => $value){
                $ordencompra = ListOrdenCompra::create([
                    'item_id' => $value['item_id'],
                    'id_persons' => $value['persona_id'],
                    'unit_price' => $value['unit_price'],
                    'id_orden_compra' => $idOrdenCompra->id
                ]);

            }
            DB::commit();
            
            
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
         return $idOrdenCompra->id; 
    }
}
