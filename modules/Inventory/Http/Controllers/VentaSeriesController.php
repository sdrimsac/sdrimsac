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
use App\Models\Tenant\Company;
use App\Models\Tenant\Document;
use App\Models\Tenant\DocumentItem;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\SaleNote;

class VentaSeriesController extends Controller
{


    public function index()
    {
        return view('inventory::reports.series.index');
    }

    public function getDataSeries(Request $request)
    {

        $dataRequest = $request->All();
        $dataForm = $dataRequest['form'];
        $establishment = auth()->user()->establishment;
        $printer = $establishment->printer;
        $dataDocumentos = Document::whereHas('items', function ($item) {
            $item->whereHas('m_item', function ($item) {
                $item->where('series_enabled', '=', 1);
            });
        });

        if (isset($dataForm['date_start']) && !isset($dataForm['date_end'])) {
            if (!is_null(($dataForm['date_start']) || ($dataForm['date_start'] && is_null($dataForm['date_end'])))) {
                $dataDocumentos->where('date_of_issue', '=', $dataForm['date_start']);
            }
        }
        if (isset($dataForm['date_start']) && isset($dataForm['date_end'])) {
            if (!is_null(($dataForm['date_start']) || ($dataForm['date_start'] && is_null($dataForm['date_end'])))) {
                $dataDocumentos->whereBetween('date_of_issue', [$dataForm['date_start'], $dataForm['date_end']]);
            }
        }

        if (isset($dataForm['establishment_id'])) {
            $dataDocumentos->where('establishment_id', '=', $dataForm['establishment_id']);
        };
        if (isset($dataForm['personas'])) {
            $dataDocumentos->where('customer_id', '=', $dataForm['personas']);
        };



        $dataDocumentos = $dataDocumentos->paginate(20);


        $company = Company::first();
        $datosSeries = [];
        if (!empty($dataDocumentos)) {
            foreach ($dataDocumentos as $llave => $document) {
                $establishment = Establishment::find($document->establishment_id);
                $description_establishment = $establishment->description;
                $all_items =  $document->items;
                foreach ($all_items as $items) {
                    foreach ($items->item->lots as $key =>  $lot) {
                            $item = $items->item;
                            $datosSeries[] =  [
                                'documentId' => $document->id,
                                'documentTypeId' => $document->document_type_id,
                                'documentNumber' => $document->series."-".$document->number,
                                'company' => $company,
                                'establishment' => $establishment,
                                'phone' => $document->customer->telephone,
                                'printer' => $printer,
                                'isNote' => false,
                                'external_id' => $document->external_id,
                                'codigoInterno' => $item->internal_id, 'establish_description' => $description_establishment, 'descripcion' => $item->description, 'series' => $lot->series, 'docSeries' => $document->series . '-' . $document->number, 'docDate' =>  $document->date_of_issue, 'itemValue' => $items->unit_value, 'pers_name' => $document->customer->name . '-' . $document->customer->number
                            ];
                    }
                }
            }
        }


        return response()->json(['datosSeries' => $datosSeries, 'dataPaginated' => $dataDocumentos]);
    }

    public function getPersonas(Request $request)
    {

        $dataPers = DB::connection('tenant')->select('select * from persons');
        return response()->json(['personas' => $dataPers]);
    }

    public function getDataSeriesSalesnotes(Request $request)
    {
        $dataRequest = $request->All();
        $dataForm = $dataRequest['form'];
        $establishment = auth()->user()->establishment;
        $printer = $establishment->printer;
        $dataDocumentos = SaleNote::whereHas('items', function ($item) {
            $item->whereHas('relation_item', function ($item) {
                $item->where('series_enabled', '=', 1);
            });
        });

        if (isset($dataForm['date_start']) && !isset($dataForm['date_end'])) {
            if (!is_null(($dataForm['date_start']) || ($dataForm['date_start'] && is_null($dataForm['date_end'])))) {
                $dataDocumentos->where('date_of_issue', '=', $dataForm['date_start']);
            }
        }
        if (isset($dataForm['date_start']) && isset($dataForm['date_end'])) {
            if (!is_null(($dataForm['date_start']) || ($dataForm['date_start'] && is_null($dataForm['date_end'])))) {
                $dataDocumentos->whereBetween('date_of_issue', [$dataForm['date_start'], $dataForm['date_end']]);
            }
        }

        if (isset($dataForm['establishment_id'])) {
            $dataDocumentos->where('establishment_id', '=', $dataForm['establishment_id']);
        };
        if (isset($dataForm['personas'])) {
            $dataDocumentos->where('customer_id', '=', $dataForm['personas']);
        };



        $dataDocumentos = $dataDocumentos->paginate(20);



        $company = Company::first();
        $datosSeries = [];
        if (!empty($dataDocumentos)) {
            foreach ($dataDocumentos as $llave => $document) {
                $establishment = Establishment::find($document->establishment_id);
                $description_establishment = $establishment->description;
                $all_items =  $document->items;
                foreach ($all_items as $items) {
                    foreach ($items->item->lots as $key =>  $lot) {
                            $item = $items->item;
                            $datosSeries[] =
    
                                [
                                    'documentId' => $document->id,
                                    'documentTypeId' => $document->document_type_id,
                                    'documentNumber' => $document->series."-".$document->number,
                                    'company' => $company,
                                    'establishment' => $establishment,
                                    'phone' => $document->customer->telephone,
                                    'printer' => $printer,
                                    'isNote' => true,
                                    'external_id' => $document->external_id,
                                    'codigoInterno' => $item->internal_id, 'establish_description' => $description_establishment, 'descripcion' => $item->description, 'series' => $lot->series, 'docSeries' => $document->series . '-' . $document->number, 'docDate' =>  $document->date_of_issue, 'itemValue' => $items->unit_value, 'pers_name' => $document->customer->name . '-' . $document->customer->number
                                ];
                    }
                }
            }
        }


        return response()->json(['datosSeries' => $datosSeries, 'dataPaginated' => $dataDocumentos]);
    }

    public function reporteexcel(Request $request)
    {

        $number = [9878285697];

        $envio = new WhatsappController;
        $sender = 'sdrimsac';
        $message = 'Reporte de series vendidas ';
        $file_name = 'TenantProcesosCaidos' . Carbon::now() . '.xlsx';
        $dataRequest = $request->all();

        $dataStart = $dataRequest['date_start'];
        if (isset($dataRequest['date_end'])) {
            $dataEnd = $dataRequest['date_end'];
        }
        if (isset($dataRequest['establishment_id'])) {
            $dataEstablis = $dataRequest['establishment_id'];
        }
        if (isset($dataRequest['personas'])) {
            $dataPersonas = $dataRequest['personas'];
        }



        $activeTab = $dataRequest['activeTab'];

        try {
            if ($activeTab == 'documents') {

                $dataDocumentos = Document::whereHas('items', function ($item) {
                    $item->whereHas('m_item', function ($item) {
                        $item->where('series_enabled', '=', 1);
                    });
                });
        
                if (isset($dataForm['date_start']) && !isset($dataForm['date_end'])) {
                    if (!is_null(($dataForm['date_start']) || ($dataForm['date_start'] && is_null($dataForm['date_end'])))) {
                        $dataDocumentos->where('date_of_issue', '=', $dataForm['date_start']);
                    }
                }
                if (isset($dataForm['date_start']) && isset($dataForm['date_end'])) {
                    if (!is_null(($dataForm['date_start']) || ($dataForm['date_start'] && is_null($dataForm['date_end'])))) {
                        $dataDocumentos->whereBetween('date_of_issue', [$dataForm['date_start'], $dataForm['date_end']]);
                    }
                }
        
                if (isset($dataForm['establishment_id'])) {
                    $dataDocumentos->where('establishment_id', '=', $dataForm['establishment_id']);
                };
                if (isset($dataForm['personas'])) {
                    $dataDocumentos->where('customer_id', '=', $dataForm['personas']);
                };
        
        
        
                $dataDocumentos = $dataDocumentos->get();
        
        
        
        
                $datosSeries = [];
                if (!empty($dataDocumentos)) {
                    foreach ($dataDocumentos as $llave => $document) {
                        $description_establishment = Establishment::find($document->establishment_id)->description;
                        $all_items =  $document->items;
                        foreach ($all_items as $items) {
                            foreach ($items->item->lots as $key =>  $lot) {
                                    $item = $items->item;
                                    $datosSeries[] =  [
                                        'isNote' => false,
                                        'external_id' => $document->external_id,
                                        'codigoInterno' => $item->internal_id, 'establish_description' => $description_establishment, 'descripcion' => $item->description, 'series' => $lot->series, 'docSeries' => $document->series . '-' . $document->number, 'docDate' =>  $document->date_of_issue, 'itemValue' => $items->unit_value,
                                        
                                       
                                        'pers_name' => $document->customer->name . '-' . $document->customer->number
                                    ];
                            }
                        }
                    }
                }
        

                $documento = (new SeriesSell)
                    ->datosSeries($datosSeries)
                    ->download('ReporteSeriesVendidas' . Carbon::now() . '.xlsx');
            } else {
                $dataDocumentos = SaleNote::whereHas('items', function ($item) {
                    $item->whereHas('relation_item', function ($item) {
                        $item->where('series_enabled', '=', 1);
                    });
                });
        
                if (isset($dataForm['date_start']) && !isset($dataForm['date_end'])) {
                    if (!is_null(($dataForm['date_start']) || ($dataForm['date_start'] && is_null($dataForm['date_end'])))) {
                        $dataDocumentos->where('date_of_issue', '=', $dataForm['date_start']);
                    }
                }
                if (isset($dataForm['date_start']) && isset($dataForm['date_end'])) {
                    if (!is_null(($dataForm['date_start']) || ($dataForm['date_start'] && is_null($dataForm['date_end'])))) {
                        $dataDocumentos->whereBetween('date_of_issue', [$dataForm['date_start'], $dataForm['date_end']]);
                    }
                }
        
                if (isset($dataForm['establishment_id'])) {
                    $dataDocumentos->where('establishment_id', '=', $dataForm['establishment_id']);
                };
                if (isset($dataForm['personas'])) {
                    $dataDocumentos->where('customer_id', '=', $dataForm['personas']);
                };
        
        
        
                $dataDocumentos = $dataDocumentos->get();
        
        
        
        
                $datosSeries = [];
                if (!empty($dataDocumentos)) {
                    foreach ($dataDocumentos as $llave => $document) {
                        $description_establishment = Establishment::find($document->establishment_id)->description;
                        $all_items =  $document->items;
                        foreach ($all_items as $items) {
                            foreach ($items->item->lots as $key =>  $lot) {
                                    $item = $items->item;
                                    $datosSeries[] =
            
                                        [
                                            'isNote' => true,
                                            'external_id' => $document->external_id,
                                            'codigoInterno' => $item->internal_id, 'establish_description' => $description_establishment, 'descripcion' => $item->description, 'series' => $lot->series, 'docSeries' => $document->series . '-' . $document->number, 'docDate' =>  $document->date_of_issue, 'itemValue' => $items->unit_value, 'pers_name' => $document->customer->name . '-' . $document->customer->number
                                        ];
                            }
                        }
                    }
                }
        
                $documento = (new SeriesSell)
                    ->datosSeries($datosSeries)
                    ->download('ReporteSeriesVendidas' . Carbon::now() . '.xlsx');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }





        //return 'algo por alli';
        return $documento;
    }

    public function envioReportWhastap(Request $request)
    {

        //$number = [927383973];

        $envio = new WhatsappController;
        $sender = 'sdrimsac';
        $message = 'Reporte de series vendidas ';
        $file_name = 'ReportesSeriesVendidas' . Carbon::now() . '.xlsx';

        $datosRequest = $request->all();
        $datosForm = $datosRequest['form'];


        $number = [$datosRequest['numeroWhatsapp']];

        $dataStart = $datosForm['date_start'];
        if (isset($datosForm['date_end'])) {
            $dataEnd = $datosForm['date_end'];
        }
        if (isset($datosForm['establishment_id'])) {
            $dataEstablis = $datosForm['establishment_id'];
        }
        if (isset($datosForm['personas'])) {
            $dataPersonas = $datosForm['personas'];
        }






        $activeTab = $datosRequest['activeTab'];

        if ($activeTab == 'documents') {
            $dataDocumentos = DB::connection('tenant')->table('boxes')
                ->join('ordens', 'boxes.orden_id', '=', 'ordens.id')
                ->join('documents', 'ordens.id', '=', 'documents.orden_id')
                ->join('document_items', 'documents.id', '=', 'document_items.document_id')
                ->join('items', 'document_items.item_id', '=', 'items.id')
                ->join('establishments', 'boxes.establishment_id', '=', 'establishments.id')
                ->join('persons', 'documents.customer_id', '=', 'persons.id')
                ->select('documents.series as doc_series', 'document_items.*', 'documents.number as doc_number', 'documents.date_of_issue as doc_date', 'document_items.unit_value as item_unit_value', 'establishments.description as establish_description', 'persons.name as pers_name', 'persons.number as pers_number',)
                ->where('items.series_enabled', '=', 1);

            if (isset($dataStart) && !isset($dataEnd)) {
                if (!is_null(($dataStart) || ($dataStart && is_null($dataEnd)))) {
                    $dataDocumentos->where('documents.date_of_issue', '=', $dataStart);
                }
            }

            if (isset($dataStart)  && isset($dataEnd)) {
                if (!is_null($dataStart) && !is_null($dataEnd)) {
                    $dataDocumentos->whereRaw('date_of_issue BETWEEN  ? and ? ', [$dataStart, $dataEnd]);
                }
            }

            if (isset($dataEstablis)) {
                $dataDocumentos->where('boxes.establishment_id', '=', $dataEstablis);
            }

            if (isset($dataPersonas)) {
                $dataDocumentos->where('persons.id', '=', $dataPersonas);
            }

            $dataDocumentos = $dataDocumentos->get()->toArray();

            $datosSeries = [];
            if (!empty($dataDocumentos)) {
                foreach ($dataDocumentos as $llave => $value) {
                    $detalleSell =  json_decode($value->item, true);
                    foreach ($detalleSell['lots'] as $key => $valueDetalle) {
                        $datosSeries[] =  ['codigoInterno' => $detalleSell['internal_id'], 'establish_description' => $value->establish_description, 'descripcion' => $detalleSell['description'], 'series' => $valueDetalle['series'], 'docSeries' => $value->doc_series . '-' . $value->doc_number, 'docDate' =>  $value->doc_date, 'itemValue' => $value->item_unit_value, 'pers_name' => $value->pers_name . '-' . $value->pers_number];
                    }
                }
            }

            $documento = (new SeriesSell)
                ->datosSeries($datosSeries)
                ->download('ReporteSeriesVendidas' . Carbon::now() . '.xlsx');

            $file = new File($documento->getFile());
            $request = new Request(['file' => $file, 'number' => $number, 'message' => $message, 'file_name' => $file_name, 'sender' => $sender]);

            $envio->sendReporteDocumentos($request);
        } else {
            $dataSalesnotes = DB::connection('tenant')->table('boxes')
                ->join('ordens', 'boxes.orden_id', '=', 'ordens.id')
                ->join('sale_notes', 'ordens.id', '=', 'sale_notes.orden_id')
                ->join('sale_note_items', 'sale_notes.id', '=', 'sale_note_items.sale_note_id')
                ->join('items', 'sale_note_items.item_id', '=', 'items.id')
                ->join('establishments', 'boxes.establishment_id', '=', 'establishments.id')
                ->join('persons', 'sale_notes.customer_id', '=', 'persons.id')
                ->select('sale_notes.series as sale_notes_series', 'sale_note_items.*', 'sale_notes.number as sale_notes_number', 'sale_notes.date_of_issue as sale_notes_date', 'sale_note_items.unit_value as item_unit_value', 'establishments.description as establish_description', 'persons.name as pers_name', 'persons.number as pers_number')
                ->where('items.series_enabled', '=', 1);

            if (isset($dataStart) && !isset($dataEnd)) {
                if (!is_null(($dataStart) || ($dataStart && is_null($dataEnd)))) {
                    $dataSalesnotes->where('sale_notes.date_of_issue', '=', $dataStart);
                }
            }

            if (isset($dataStart)  && isset($dataEnd)) {
                if (!is_null($dataStart) && !is_null($dataEnd)) {
                    $dataSalesnotes->whereRaw('sale_notes.date_of_issue BETWEEN  ? and ? ', [$dataStart, $dataEnd]);
                }
            }

            if (isset($dataEstablis)) {
                $dataSalesnotes->where('boxes.establishment_id', '=', $dataEstablis);
            }

            if (isset($dataPersonas)) {
                $dataSalesnotes->where('persons.id', '=', $dataPersonas);
            }

            $dataSalesnotes = $dataSalesnotes->get()->toArray();

            $datosSeriesSalesNotes = [];
            if (!empty($dataSalesnotes)) {
                foreach ($dataSalesnotes as $llave => $value) {
                    $detalleSell =  json_decode($value->item, true);
                    foreach ($detalleSell['lots'] as $key => $valueDetalle) {
                        $datosSeriesSalesNotes[] =  ['codigoInterno' => $detalleSell['internal_id'], 'establish_description' => $value->establish_description, 'descripcion' => $detalleSell['description'], 'series' => $valueDetalle['series'], 'docSeries' => $value->sale_notes_series . '-' . $value->sale_notes_number, 'docDate' =>  $value->sale_notes_date, 'itemValue' => $value->item_unit_value, 'pers_name' => $value->pers_name . '-' . $value->pers_number];
                    }
                }
            }
            $documento = (new SeriesSell)
                ->datosSeries($datosSeriesSalesNotes)
                ->download('ReporteSeriesVendidas' . Carbon::now() . '.xlsx');

            $file = new File($documento->getFile());
            $request = new Request(['file' => $file, 'number' => $number, 'message' => $message, 'file_name' => $file_name, 'sender' => $sender]);

            $envio->sendReporteDocumentos($request);
        }

        return 'enviado correctamente';
    }
}
