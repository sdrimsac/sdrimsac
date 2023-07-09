<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Inventory\Http\Resources\InventoryCollection;
use Modules\Inventory\Http\Resources\InventoryCollection2;

use Modules\Inventory\Http\Resources\InventoryResource;
use Modules\Inventory\Models\Inventory;
use Modules\Inventory\Models\InventoryTransaction;
use Modules\Inventory\Traits\InventoryTrait;
use Modules\Inventory\Models\ItemWarehouse;
use Modules\Inventory\Models\Warehouse;
use Modules\Inventory\Http\Requests\InventoryRequest;
use Modules\Item\Models\ItemLot;

class VentaSeriesController extends Controller
{
    

    public function index()
    {
        return view('inventory::reports.series.index');
    }

    public function getDataSeries(Request $request){

        dump($request->all());

        $dataDocumentos = DB::connection('tenant')->table('boxes')
                        ->join('ordens', 'boxes.orden_id', '=', 'ordens.id')
                        ->join('documents', 'ordens.id', '=', 'documents.orden_id')
                        ->join('document_items', 'documents.id', '=', 'document_items.document_id')
                        ->join('items', 'document_items.item_id', '=', 'items.id')
                        ->select('documents.series as doc_series', 'document_items.*' ,'documents.number as doc_number' ,'documents.date_of_issue as doc_date' , 'document_items.unit_value as item_unit_value')
                        ->where('items.series_enabled' , '=', 1)
                        ->paginate(20);
                        
           
                    //AND ordens.id = documents.orden_id
       
        $datosSeries = [] ; 
        if (!empty($dataDocumentos)) {
            foreach ($dataDocumentos as $llave => $value) {
                $detalleSell =  json_decode($value->item, true);
                foreach ($detalleSell['lots'] as $key => $valueDetalle) {
                    $datosSeries[] =  ['codigoInterno'=> $detalleSell['internal_id']  ,'descripcion'=> $detalleSell['description'] , 'series'=> $valueDetalle['series'] , 'docSeries'=> $value->doc_series.'-'. $value->doc_number ,'docDate'=>  $value->doc_date ,'itemValue'=> $value->item_unit_value ]; 
                }
            }
        }
        //dump($datosSeries);

        return response()->json(['datosSeries' => $datosSeries, 'dataPaginated'=> $dataDocumentos]); 
    }

}
