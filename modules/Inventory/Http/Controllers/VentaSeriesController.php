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

        $dataRequest = $request->All();
        $dataForm = $dataRequest['form']; 

        

        $dataDocumentos = DB::connection('tenant')->table('boxes')
                        ->join('ordens', 'boxes.orden_id', '=', 'ordens.id')
                        ->join('documents', 'ordens.id', '=', 'documents.orden_id')
                        ->join('document_items', 'documents.id', '=', 'document_items.document_id')
                        ->join('items', 'document_items.item_id', '=', 'items.id')
                        ->join('establishments', 'boxes.establishment_id', '=', 'establishments.id')
                        ->join('persons', 'documents.customer_id', '=', 'persons.id')
                        ->select('documents.series as doc_series', 'document_items.*' ,'documents.number as doc_number' ,'documents.date_of_issue as doc_date' , 'document_items.unit_value as item_unit_value' , 'establishments.description as establish_description' ,'persons.name as pers_name' ,'persons.number as pers_number' ,)
                        ->where('items.series_enabled' , '=', 1);

                        if(isset($dataForm['date_start']) && !isset($dataForm['date_end']) ){
                                if(!is_null(($dataForm['date_start']) || ($dataForm['date_start'] && is_null($dataForm['date_end'] )  ))){
                                    $dataDocumentos->where('documents.date_of_issue' , '=', $dataForm['date_start']);
                                }
                                
                        } 

                        if(isset($dataForm['date_start'])  && isset($dataForm['date_end'])){ 
                            if(!is_null($dataForm['date_start']) && !is_null($dataForm['date_end'])){
                                $dataDocumentos->whereRaw('date_of_issue BETWEEN  ? and ? ', [$dataForm['date_start'] , $dataForm['date_end']] );
                            }
                        }
                        
                        if(isset($dataForm['establishment_id'])){
                            $dataDocumentos->where('boxes.establishment_id' , '=', $dataForm['establishment_id']);
                        }

                        if(isset($dataForm['personas'])){
                            $dataDocumentos->where('persons.id' , '=', $dataForm['personas']);
                                            
                        }
                        
                        
                        //BUSCAR POR NUMERO DE DNI DEL CLIENTE O NOMBRE DEL CLIENTE 
                        
                        
           
                    
       
        $dataDocumentos =$dataDocumentos->paginate(20);

        $datosSeries = [] ; 
        if (!empty($dataDocumentos)) {
            foreach ($dataDocumentos as $llave => $value) {
                $detalleSell =  json_decode($value->item, true);
                foreach ($detalleSell['lots'] as $key => $valueDetalle) {
                    $datosSeries[] =  ['codigoInterno'=> $detalleSell['internal_id'],'establish_description' => $value->establish_description  ,'descripcion'=> $detalleSell['description'] , 'series'=> $valueDetalle['series'] , 'docSeries'=> $value->doc_series.'-'. $value->doc_number ,'docDate'=>  $value->doc_date ,'itemValue'=> $value->item_unit_value , 'pers_name'=> $value->pers_name . '-'. $value->pers_number]; 
                }
            }
        }

        return response()->json(['datosSeries' => $datosSeries, 'dataPaginated'=> $dataDocumentos]); 
    }

    public function getPersonas(Request $request){
        
        $dataPers = DB::connection('tenant')->select('select * from persons') ; 
        return response()->json(['personas' => $dataPers]); 
    }

    public function getDataSeriesSalesnotes(Request $request){
        $dataRequest = $request->All();
        $dataForm = $dataRequest['form']; 

        $dataSalesnotes = DB::connection('tenant')->table('boxes')
            ->join('ordens', 'boxes.orden_id', '=', 'ordens.id')
            ->join('sale_notes', 'ordens.id', '=', 'sale_notes.id')
            ->join('sale_note_items', 'sale_notes.id', '=', 'sale_note_items.sale_note_id')
            ->join('items', 'sale_note_items.item_id', '=', 'items.id')
            ->join('establishments', 'boxes.establishment_id', '=', 'establishments.id')
            ->join('persons', 'sale_notes.customer_id', '=', 'persons.id')
            ->select('sale_notes.series as sale_notes_series', 'sale_note_items.*' ,'sale_notes.number as sale_notes_number' ,'sale_notes.date_of_issue as sale_notes_date' , 'sale_note_items.unit_value as item_unit_value' , 'establishments.description as establish_description' ,'persons.name as pers_name' ,'persons.number as pers_number')
            ->where('items.series_enabled' , '=', 1);
            if(isset($dataForm['date_start']) && !isset($dataForm['date_end']) ){
                if(!is_null(($dataForm['date_start']) || ($dataForm['date_start'] && is_null($dataForm['date_end'] )  ))){
                    $dataSalesnotes->where('sale_notes.date_of_issue' , '=', $dataForm['date_start']);
                }
                
                } 

                if(isset($dataForm['date_start'])  && isset($dataForm['date_end'])){ 
                    if(!is_null($dataForm['date_start']) && !is_null($dataForm['date_end'])){
                        $dataSalesnotes->whereRaw('sale_notes.date_of_issue BETWEEN  ? and ? ', [$dataForm['date_start'] , $dataForm['date_end']] );
                    }
                }
                
                if(isset($dataForm['establishment_id'])){
                    $dataSalesnotes->where('boxes.establishment_id' , '=', $dataForm['establishment_id']);
                }

                if(isset($dataForm['personas'])){
                    $dataSalesnotes->where('persons.id' , '=', $dataForm['personas']);
                                    
                }

            $dataSalesnotes = $dataSalesnotes->paginate(20);

        $datosSeriesSalesNotes = [] ; 
        if (!empty($dataSalesnotes)) {
            foreach ($dataSalesnotes as $llave => $value) {
                $detalleSell =  json_decode($value->item, true);
                foreach ($detalleSell['lots'] as $key => $valueDetalle) {
                    $datosSeriesSalesNotes[] =  ['codigoInterno'=> $detalleSell['internal_id'],'establish_description' => $value->establish_description  ,'descripcion'=> $detalleSell['description'] , 'series'=> $valueDetalle['series'] , 'sale_notes_series'=> $value->sale_notes_series.'-'. $value->sale_notes_number ,'docDate'=>  $value->sale_notes_date ,'itemValue'=> $value->item_unit_value , 'pers_name'=> $value->pers_name . '-'. $value->pers_number]; 
                }
            }
        }

        return response()->json(['datosSeries' => $datosSeriesSalesNotes, 'dataPaginated'=> $dataSalesnotes]); 
        
    }

    public function reporteexcel(Request $request){

        return 'haciendo excel ';
    }

}
