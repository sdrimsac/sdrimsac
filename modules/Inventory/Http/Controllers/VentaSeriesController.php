<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\File;
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
use Modules\Inventory\Models\SeriesSell;
use Carbon\Carbon;
use App\Http\Controllers\Tenant\WhatsappController;

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
            ->join('sale_notes', 'ordens.id', '=', 'sale_notes.orden_id')
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

        $number = [927383973];

        $envio = new WhatsappController ;
        $sender = 'sdrimsac';
        $message = 'Reporte de series vendidas ';
        $file_name = 'TenantProcesosCaidos' . Carbon::now() . '.xlsx';
        $dataRequest = $request->all();

        $dataStart = $dataRequest['date_start']; 
        if(isset($dataRequest['date_end'])){
            $dataEnd = $dataRequest['date_end']; 
        }
        if(isset($dataRequest['establishment_id'])){
            $dataEstablis = $dataRequest['establishment_id']; 
        }
        if(isset($dataRequest['personas'])){
            $dataPersonas = $dataRequest['personas']; 
        }
        
        
        
        $activeTab = $dataRequest['activeTab'];
  
        try {
            if($activeTab == 'documents'){
            

                $dataDocumentos = DB::connection('tenant')->table('boxes')
                ->join('ordens', 'boxes.orden_id', '=', 'ordens.id')
                ->join('documents', 'ordens.id', '=', 'documents.orden_id')
                ->join('document_items', 'documents.id', '=', 'document_items.document_id')
                ->join('items', 'document_items.item_id', '=', 'items.id')
                ->join('establishments', 'boxes.establishment_id', '=', 'establishments.id')
                ->join('persons', 'documents.customer_id', '=', 'persons.id')
                ->select('documents.series as doc_series', 'document_items.*' ,'documents.number as doc_number' ,'documents.date_of_issue as doc_date' , 'document_items.unit_value as item_unit_value' , 'establishments.description as establish_description' ,'persons.name as pers_name' ,'persons.number as pers_number' ,)
                ->where('items.series_enabled' , '=', 1);
    
                if(isset($dataStart) && !isset($dataEnd) ){
                        if(!is_null(($dataStart) || ($dataStart && is_null($dataEnd )  ))){
                            $dataDocumentos->where('documents.date_of_issue' , '=', $dataStart);
                        }
                        
                } 
    
                if(isset($dataStart)  && isset($dataEnd)){ 
                    if(!is_null($dataStart) && !is_null($dataEnd)){
                        $dataDocumentos->whereRaw('date_of_issue BETWEEN  ? and ? ', [$dataStart , $dataEnd] );
                    }
                }
                
                if(isset($dataEstablis)){
                    $dataDocumentos->where('boxes.establishment_id' , '=', $dataEstablis);
                }
    
                if(isset($dataPersonas)){
                    $dataDocumentos->where('persons.id' , '=', $dataPersonas);
                }
                
                $dataDocumentos =$dataDocumentos->get()->toArray();
    
                    $datosSeries = [] ; 
                    if (!empty($dataDocumentos)) {
                        foreach ($dataDocumentos as $llave => $value) {
                        $detalleSell =  json_decode($value->item, true);
                            foreach ($detalleSell['lots'] as $key => $valueDetalle) {
                                $datosSeries[] =  ['codigoInterno'=> $detalleSell['internal_id'],'establish_description' => $value->establish_description  ,'descripcion'=> $detalleSell['description'] , 'series'=> $valueDetalle['series'] , 'docSeries'=> $value->doc_series.'-'. $value->doc_number ,'docDate'=>  $value->doc_date ,'itemValue'=> $value->item_unit_value , 'pers_name'=> $value->pers_name . '-'. $value->pers_number]; 
                            }
                        }
                    }
    
                    $documento = (new SeriesSell) 
                        ->datosSeries($datosSeries)
                        ->download('ReporteSeriesVendidas' . Carbon::now() . '.xlsx');     
            }else{
                $dataSalesnotes = DB::connection('tenant')->table('boxes')
                ->join('ordens', 'boxes.orden_id', '=', 'ordens.id')
                ->join('sale_notes', 'ordens.id', '=', 'sale_notes.orden_id')
                ->join('sale_note_items', 'sale_notes.id', '=', 'sale_note_items.sale_note_id')
                ->join('items', 'sale_note_items.item_id', '=', 'items.id')
                ->join('establishments', 'boxes.establishment_id', '=', 'establishments.id')
                ->join('persons', 'sale_notes.customer_id', '=', 'persons.id')
                ->select('sale_notes.series as sale_notes_series', 'sale_note_items.*' ,'sale_notes.number as sale_notes_number' ,'sale_notes.date_of_issue as sale_notes_date' , 'sale_note_items.unit_value as item_unit_value' , 'establishments.description as establish_description' ,'persons.name as pers_name' ,'persons.number as pers_number')
                ->where('items.series_enabled' , '=', 1);

                if(isset($dataStart) && !isset($dataEnd) ){
                    if(!is_null(($dataStart) || ($dataStart && is_null($dataEnd )  ))){
                        $dataSalesnotes->where('sale_notes.date_of_issue' , '=', $dataStart);
                    }
                    
                    } 

                    if(isset($dataStart)  && isset($dataEnd)){ 
                        if(!is_null($dataStart) && !is_null($dataEnd)){
                            $dataSalesnotes->whereRaw('sale_notes.date_of_issue BETWEEN  ? and ? ', [$dataStart , $dataEnd] );
                        }
                    }
                    
                    if(isset($dataEstablis)){
                        $dataSalesnotes->where('boxes.establishment_id' , '=', $dataEstablis);
                    }

                    if(isset($dataPersonas)){
                        $dataSalesnotes->where('persons.id' , '=', $dataPersonas);
                                        
                    }

                    $dataSalesnotes =$dataSalesnotes->get()->toArray();

                    $datosSeriesSalesNotes = [] ; 
                if (!empty($dataSalesnotes)) {
                    foreach ($dataSalesnotes as $llave => $value) {
                        $detalleSell =  json_decode($value->item, true);
                        foreach ($detalleSell['lots'] as $key => $valueDetalle) {
                            $datosSeriesSalesNotes[] =  ['codigoInterno'=> $detalleSell['internal_id'],'establish_description' => $value->establish_description  ,'descripcion'=> $detalleSell['description'] , 'series'=> $valueDetalle['series'] , 'docSeries'=> $value->sale_notes_series.'-'. $value->sale_notes_number ,'docDate'=>  $value->sale_notes_date ,'itemValue'=> $value->item_unit_value , 'pers_name'=> $value->pers_name . '-'. $value->pers_number]; 
                        }
                    }
                }
                $documento = (new SeriesSell) 
                        ->datosSeries($datosSeriesSalesNotes)
                        ->download('ReporteSeriesVendidas' . Carbon::now() . '.xlsx'); 
                    
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        
        

        
        //return 'algo por alli';
        return $documento;
    }

    public function envioReportWhastap(Request $request){
        
        //$number = [927383973];

        $envio = new WhatsappController ;
        $sender = 'sdrimsac';
        $message = 'Reporte de series vendidas ';
        $file_name = 'ReportesSeriesVendidas' . Carbon::now() . '.xlsx';
        
        $datosRequest = $request->all();
        $datosForm = $datosRequest['form'];

        
        $number = [$datosRequest['numeroWhatsapp']];

        $dataStart = $datosForm['date_start']; 
        if(isset($datosForm['date_end'])){
            $dataEnd = $datosForm['date_end']; 
        }
        if(isset($datosForm['establishment_id'])){
            $dataEstablis = $datosForm['establishment_id']; 
        }
        if(isset($datosForm['personas'])){
            $dataPersonas = $datosForm['personas']; 
        }
        
        
        
        
        

        $activeTab = $datosRequest['activeTab'];

        if($activeTab == 'documents' ){
            $dataDocumentos = DB::connection('tenant')->table('boxes')
                ->join('ordens', 'boxes.orden_id', '=', 'ordens.id')
                ->join('documents', 'ordens.id', '=', 'documents.orden_id')
                ->join('document_items', 'documents.id', '=', 'document_items.document_id')
                ->join('items', 'document_items.item_id', '=', 'items.id')
                ->join('establishments', 'boxes.establishment_id', '=', 'establishments.id')
                ->join('persons', 'documents.customer_id', '=', 'persons.id')
                ->select('documents.series as doc_series', 'document_items.*' ,'documents.number as doc_number' ,'documents.date_of_issue as doc_date' , 'document_items.unit_value as item_unit_value' , 'establishments.description as establish_description' ,'persons.name as pers_name' ,'persons.number as pers_number' ,)
                ->where('items.series_enabled' , '=', 1);
    
                if(isset($dataStart) && !isset($dataEnd) ){
                        if(!is_null(($dataStart) || ($dataStart && is_null($dataEnd )  ))){
                            $dataDocumentos->where('documents.date_of_issue' , '=', $dataStart);
                        }
                        
                } 
    
                if(isset($dataStart)  && isset($dataEnd)){ 
                    if(!is_null($dataStart) && !is_null($dataEnd)){
                        $dataDocumentos->whereRaw('date_of_issue BETWEEN  ? and ? ', [$dataStart , $dataEnd] );
                    }
                }
                
                if(isset($dataEstablis)){
                    $dataDocumentos->where('boxes.establishment_id' , '=', $dataEstablis);
                }
    
                if(isset($dataPersonas)){
                    $dataDocumentos->where('persons.id' , '=', $dataPersonas);
                }
                
                $dataDocumentos =$dataDocumentos->get()->toArray();
    
                    $datosSeries = [] ; 
                    if (!empty($dataDocumentos)) {
                        foreach ($dataDocumentos as $llave => $value) {
                        $detalleSell =  json_decode($value->item, true);
                            foreach ($detalleSell['lots'] as $key => $valueDetalle) {
                                $datosSeries[] =  ['codigoInterno'=> $detalleSell['internal_id'],'establish_description' => $value->establish_description  ,'descripcion'=> $detalleSell['description'] , 'series'=> $valueDetalle['series'] , 'docSeries'=> $value->doc_series.'-'. $value->doc_number ,'docDate'=>  $value->doc_date ,'itemValue'=> $value->item_unit_value , 'pers_name'=> $value->pers_name . '-'. $value->pers_number]; 
                            }
                        }
                    }
    
                    $documento = (new SeriesSell) 
                        ->datosSeries($datosSeries)
                        ->download('ReporteSeriesVendidas' . Carbon::now() . '.xlsx'); 
                        
                        $file = new File($documento->getFile());
                        $request = new Request(['file' => $file , 'number'=> $number, 'message' => $message  , 'file_name' => $file_name , 'sender' => $sender]);
            
                        $envio->sendReporteDocumentos($request);
        }else{
            $dataSalesnotes = DB::connection('tenant')->table('boxes')
                ->join('ordens', 'boxes.orden_id', '=', 'ordens.id')
                ->join('sale_notes', 'ordens.id', '=', 'sale_notes.orden_id')
                ->join('sale_note_items', 'sale_notes.id', '=', 'sale_note_items.sale_note_id')
                ->join('items', 'sale_note_items.item_id', '=', 'items.id')
                ->join('establishments', 'boxes.establishment_id', '=', 'establishments.id')
                ->join('persons', 'sale_notes.customer_id', '=', 'persons.id')
                ->select('sale_notes.series as sale_notes_series', 'sale_note_items.*' ,'sale_notes.number as sale_notes_number' ,'sale_notes.date_of_issue as sale_notes_date' , 'sale_note_items.unit_value as item_unit_value' , 'establishments.description as establish_description' ,'persons.name as pers_name' ,'persons.number as pers_number')
                ->where('items.series_enabled' , '=', 1);

                if(isset($dataStart) && !isset($dataEnd) ){
                    if(!is_null(($dataStart) || ($dataStart && is_null($dataEnd )  ))){
                        $dataSalesnotes->where('sale_notes.date_of_issue' , '=', $dataStart);
                    }
                    
                    } 

                    if(isset($dataStart)  && isset($dataEnd)){ 
                        if(!is_null($dataStart) && !is_null($dataEnd)){
                            $dataSalesnotes->whereRaw('sale_notes.date_of_issue BETWEEN  ? and ? ', [$dataStart , $dataEnd] );
                        }
                    }
                    
                    if(isset($dataEstablis)){
                        $dataSalesnotes->where('boxes.establishment_id' , '=', $dataEstablis);
                    }

                    if(isset($dataPersonas)){
                        $dataSalesnotes->where('persons.id' , '=', $dataPersonas);
                                        
                    }

                    $dataSalesnotes =$dataSalesnotes->get()->toArray();

                    $datosSeriesSalesNotes = [] ; 
                if (!empty($dataSalesnotes)) {
                    foreach ($dataSalesnotes as $llave => $value) {
                        $detalleSell =  json_decode($value->item, true);
                        foreach ($detalleSell['lots'] as $key => $valueDetalle) {
                            $datosSeriesSalesNotes[] =  ['codigoInterno'=> $detalleSell['internal_id'],'establish_description' => $value->establish_description  ,'descripcion'=> $detalleSell['description'] , 'series'=> $valueDetalle['series'] , 'docSeries'=> $value->sale_notes_series.'-'. $value->sale_notes_number ,'docDate'=>  $value->sale_notes_date ,'itemValue'=> $value->item_unit_value , 'pers_name'=> $value->pers_name . '-'. $value->pers_number]; 
                        }
                    }
                }
                $documento = (new SeriesSell) 
                        ->datosSeries($datosSeriesSalesNotes)
                        ->download('ReporteSeriesVendidas' . Carbon::now() . '.xlsx'); 

                        $file = new File($documento->getFile());
                        $request = new Request(['file' => $file , 'number'=> $number, 'message' => $message  , 'file_name' => $file_name , 'sender' => $sender]);
            
                        $envio->sendReporteDocumentos($request);
        }

        return 'enviado correctamente';
    }

}
