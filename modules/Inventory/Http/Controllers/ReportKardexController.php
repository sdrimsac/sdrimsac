<?php

namespace Modules\Inventory\Http\Controllers;

use App\CoreFacturalo\Requests\Inputs\Functions;
use Carbon\Carbon;
use App\Models\Tenant\Item;
use Illuminate\Http\Request;
use App\Models\Tenant\Kardex;
use App\Models\Tenant\Company;
use App\Models\Tenant\Document;
use App\Models\Tenant\Purchase;
use App\Models\Tenant\Inventory;
use Modules\Item\Models\ItemLot;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant\DocumentItem;
use App\Models\Tenant\PurchaseItem;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Establishment;
use Modules\Item\Models\ItemLotsGroup;
use Illuminate\Support\Facades\Storage;

use Modules\Inventory\Models\Warehouse;
use Illuminate\Support\Facades\Response;
use Modules\Inventory\Exports\KardexExport;
use Modules\Inventory\Models\ItemWarehouse;
use Modules\Inventory\Exports\KardexExport2;
use Modules\Inventory\Models\InventoryKardex;
use Modules\Inventory\Http\Resources\ReportKardexCollection;
use Modules\Inventory\Http\Resources\ReportKardexLotsCollection;
use Modules\Inventory\Http\Resources\ReportKardexItemLotCollection;
use Modules\Inventory\Http\Resources\ReportKardexLotsGroupCollection;


class ReportKardexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        ini_set('memory_limit', '-1');
    }
    protected $models = [
        "App\Models\Tenant\Document",
        "App\Models\Tenant\Purchase",
        "App\Models\Tenant\SaleNote",
        "Modules\Inventory\Models\Inventory",
        "Modules\Order\Models\OrderNote",
        "App\Models\Tenant\CreditList",
        "Modules\Item\Models\ItemManufactured",
    ];

    public function index()
    {

        $establecimiento =  DB::connection('tenant')->select('select * from establishments');

        return view('inventory::reports.kardex.index')->with('establecimiento', $establecimiento);
    }


    public function filter()
    {

        $items = Item::query()->whereNotIsSet()
            ->where([['item_type_id', '01'], ['unit_type_id', '!=', 'ZZ']])
            ->latest()
            ->get()->take(20)->transform(function ($row) {
                $full_description = $this->getFullDescription($row);
                return [
                    'id' => $row->id,
                    'full_description' => $full_description,
                    'internal_id' => $row->internal_id,
                    'description' => $row->description,
                ];
            });

        return compact('items');
    }


    public function records(Request $request, $note = true)
    {
        $stablecimiento = $request->id_establecimiento;

        $records = $this->getRecords($request->all(), $note);


        return new ReportKardexCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function records_lots()
    {
        $records = ItemWarehouse::with(['item'])->whereHas('item', function ($q) {
            $q->where([['item_type_id', '01'], ['unit_type_id', '!=', 'ZZ'], ['lot_code', '!=', null]]);
            $q->whereNotIsSet();
        });

        return new ReportKardexLotsCollection($records->paginate(config('tenant.items_per_page')));
    }



    public function getRecords($request, $note = true)
    {

        $item_id = $request['item_id'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $establish = Functions::valueKeyInArray($request, 'establish', null);

        $records = $this->data($item_id, $date_start, $date_end, $note, $establish);

        return $records;
    }


    private function data($item_id = null, $date_start, $date_end, $note = true, $establish)
    {

        if (!$establish) {
            $warehouse = Warehouse::where('establishment_id', auth()->user()->establishment_id)->first();
        } else {

            $warehouse = $establish;
        }

        if ($date_start && $date_end) {

            if ($note == false) {

                $data = InventoryKardex::with(['inventory_kardexable'])
                    ->where([['warehouse_id', $warehouse]])
                    ->where('inventory_kardexable_type', "!=", "App\Models\SaleNote")
                    ->whereBetween('date_of_issue', [$date_start, $date_end])
                    ->orderBy('item_id')->orderBy('id');
            } else {
                $data = InventoryKardex::with(['inventory_kardexable'])
                    ->where([['warehouse_id', $warehouse]])
                    ->whereBetween('date_of_issue', [$date_start, $date_end])
                    ->orderBy('item_id')->orderBy('id');;
            }
        } else {
            if ($note == false) {

                $data = InventoryKardex::with(['inventory_kardexable'])
                    ->where([['warehouse_id', $warehouse]])
                    ->where('inventory_kardexable_type', "!=", "App\Models\SaleNote")
                    ->orderBy('item_id')->orderBy('id');
            } else {

                $data = InventoryKardex::with(['inventory_kardexable'])
                    ->where([['warehouse_id', $warehouse]])
                    ->orderBy('item_id')->orderBy('id');
            }
        }


        if ($item_id) {
            $data = $data->where('item_id', $item_id);
        }


        return $data;
    }



    public function getFullDescription($row)
    {

        $desc = ($row->internal_id) ? $row->internal_id . ' - ' . $row->description : $row->description;
        $category = ($row->category) ? " - {$row->category->name}" : "";
        $brand = ($row->brand) ? " - {$row->brand->name}" : "";

        $desc = "{$desc} {$category} {$brand}";

        return $desc;
    }



    /**
     * PDF
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function pdf(Request $request)
    {
       
        $balance = 0;
        $max_quantity = $request->max_quantity ? ($request->max_quantity == "true" ? true : false) : false;
        $company = Company::first();
        $establishment = Establishment::first();
        $d = $request->date_start;
        $a = $request->date_end;
        $item_id = $request->item_id;
        $models = $this->models;
        // $records = $this->getRecords($request->all());
        $item_id = $request['item_id'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $records = $this->getRecords($request->all(), true);
        // $records = $this->data($item_id, $date_start, $date_end, false, $establishment);
        $reports = new ReportKardexCollection($records->get());
        //$reports=$this->records($request);

        $pdf = PDF::loadView('inventory::reports.kardex.report_pdf', compact("reports", "company", "establishment", "balance", "models", 'a', 'd', "item_id", "max_quantity"))->setPaper('a4', 'landscape');
        $filename = 'Reporte_Kardex' . date('YmdHis');

        return $pdf->stream($filename . '.pdf');
    }
    public function excel(Request $request)
    {

        $balance = 0;
        $company = Company::first();
        $establishment = Establishment::first();
        $d = $request->date_start;
        $a = $request->date_end;
        $max_quantity = $request->max_quantity ? ($request->max_quantity == "true" ? true : false) : false;

        $item_id = $request->item_id;
        $warehouse = Warehouse::where('establishment_id', auth()->user()->establishment_id)->first();
        if ($d && $a) {
            $records = InventoryKardex::with(['inventory_kardexable'])
                ->where([['warehouse_id', $warehouse->id]])
                ->whereBetween('date_of_issue', [$d, $a])
                ->orderBy('item_id')->orderBy('id')
                ->get();
        } else {
            $records = InventoryKardex::with(['inventory_kardexable'])
                ->where([['warehouse_id', $warehouse->id]])
                ->orderBy('item_id')->orderBy('id')
                ->get();
        }

        if ($item_id) {
            $records = $records->where('item_id', $item_id);
        }
        $item_id = $request['item_id'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $records = $this->data($item_id, $date_start, $date_end, false, $establishment);
        $records = $this->getRecords($request->all(), true);
        $reports = new ReportKardexCollection($records->get());
        // $reports = collect($reports);
        $models = $this->models;
        return (new KardexExport)
            ->balance($balance)
            ->item_id($item_id)
            ->records($reports)
            ->models($models)
            ->company($company)
            ->max_quantity($max_quantity)
            ->establishment($establishment)
            ->download('ReporteKar' . Carbon::now() . '.xlsx');
    }

    public function pdf_inventory_sunat(Request $request)
    {
        $balance = 0;
        $company = Company::first();
        $establishment = Establishment::first();
        $d = $request->date_start;
        $a = $request->date_end;
        $item_id = $request->item_id;
        $models = $this->models;
        // $records = $this->getRecords($request->all());
        $item_id = $request['item_id'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $records = $this->data($item_id, $date_start, $date_end, false, $establishment);
        $reports = new ReportKardexCollection($records->get());
        //$reports=$this->records($request);
        $pdf = PDF::loadView('inventory::reports.kardex.report_inventory_pdf', compact("reports", "company", "establishment", "balance", "models", 'a', 'd', "item_id"))->setPaper('a4', 'landscape');
        $filename = 'Reporte_Kardex' . date('YmdHis');

        return $pdf->stream($filename . '.pdf');
    }
    public function txt_inventory_sunat(Request $request)
    {
        $balance = 0;
        $models = $this->models;
        $company = Company::first();
        //    // $records = $this->getRecords($request->all());
        $internal_id = $request['internal_id'];
        $item_id     = $request['item_id'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $records = $this->getRecords($request->all(), false);

        $reports = new ReportKardexCollection($records->get());

        $data = collect($reports);
        //$reports=$this->records($request);

        //    $pdf = PDF::loadView('inventory::reports.kardex.report_txt', compact("reports", "company", "establishment", "balance","models", 'a', 'd',"item_id"))->setPaper('a4', 'landscape');
        //    $filename = 'Reporte_Kardex'.date('YmdHis');

        //    return $pdf->stream($filename.'.pdf');
        $contenido = "PERIODO|NUMERO CORRELATIVO CUO|NUMERO CORRELATIVO DEL ASIENTO|CODIGO DE ESTABLECIMIENTO|CODIGO DEL CATALOGO|TIPO DE EXISTENCIA|CODIGO PROPIO DE LA EXISTENCIA|CODIGO sistema|CODIGO CBSO|Fecha emision del documento|Tipo del Documento|Numero de serie del documento|Numero del documento|Tipo de Operación efectuada|Descripcion producto|Nomenclatura|Entrada|Salida|Saldo|Codigo Sistema|" . "\n";
        foreach ($data as $key => $row) {

            $contenido .=  substr($date_start, 0, 4) . substr($date_start, 5, 2) . "00|";
            $contenido .= $row['internal_id'] . "|";
            $contenido .= $row['asiento'] . "|";
            $contenido .= "0000" . "|";
            $contenido .= $row['internal_id'] . "|";
            $contenido .= $row['internal_id'] . "|";
            $contenido .= $row['internal_id'] . "|";
            $contenido .= "0" . "|";
            $contenido .= "0" . "|";
            //if($row['asiento']=="C-2"){

            //}
            $contenido .= $row['date_of_issue'] . "|";
            if ($row['asiento'] == "A-1") {
                $contenido .= "99" . "|";
            } else {
                $contenido .= $row['document_type_id'] . "|";
            }
            $contenido .= $row['series'] . "|";
            $contenido .= $row['number'] . "|";
            $contenido .= $row['operacion_efectuada'] . "|";
            $contenido .= $row['item_name'] . "|";
            $contenido .= $row['unit_type_id'] . "|";
            if ($row['asiento'] == "A-1") {
                $contenido .= number_format($row['input'], 2, ".", "") . "|";
                $contenido .= "0.00" . "|";
            } else if ($row['asiento'] == "C-2") {
                $contenido .= round($row['input'], 2) . "|";
                $contenido .= "0.00" . "|";
            } else if ($row['asiento'] == "V-1") {
                $contenido .= "0.00" . "|";
                $contenido .=  $row['output'] . "|";
                //round($row['output'],2)."|";
            }

            if ($row['asiento'] == "A-1") {
                $contenido .=  number_format(str_replace(",", ".", $row['balance']), 2, ".", "") . "|";
            }
            if ($row['asiento'] == "V-1") {
                $contenido .=  number_format(str_replace(",", ".", $row['balance']), 2, ".", "") . "|";
            } else if ($row['asiento'] == "C-2") {
                // $balance=(($inventory->quantity+$compras)-abs($ventas)+abs($row['input']));
                $contenido .=  number_format(str_replace(",", ".", $row['balance']), 2, ".", "") . "|";
            }

            //}
            // if($row['item_id']=="58" && $row['number']=="428"){
            //     dd($inventory->quantity,$compras,$ventas);
            // }
            $contenido .=  "1|" . "\n";
        }



        Storage::disk('public')->put("txt/" . $date_start . $date_end . "_" . $company->number . "_inventario_sunat.txt", $contenido);
        return Response::download(public_path("storage/txt/" . $date_start . $date_end . "_" . $company->number . "_inventario_sunat.txt"));
        //     $success=true;
        //    return [
        //        "success" => true,
        //        "message" => "se genero con exito",
        //        "file"    => "txt/".$date_start.$date_end."_".$company->number."_inventario_sunat.txt"

        //    ];
    }
    public function excel_inventory_sunat(Request $request)
    {

        $balance = 0;
        $company = Company::first();
        $establishment = Establishment::first();
        $d = $request->date_start;
        $a = $request->date_end;
        $item_id = $request->item_id;
        $warehouse = Warehouse::where('establishment_id', auth()->user()->establishment_id)->first();
        if ($d && $a) {
            $records = InventoryKardex::with(['inventory_kardexable'])
                ->where([['warehouse_id', $warehouse->id]])
                ->whereBetween('date_of_issue', [$d, $a])
                ->orderBy('item_id')->orderBy('id')
                ->get();
        } else {
            $records = InventoryKardex::with(['inventory_kardexable'])
                ->where([['warehouse_id', $warehouse->id]])
                ->orderBy('item_id')->orderBy('id')
                ->get();
        }

        if ($item_id) {
            $records = $records->where('item_id', $item_id);
        }
        $item_id = $request['item_id'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $records = $this->data($item_id, $date_start, $date_end, false, $establishment);
        $reports = new ReportKardexCollection($records->get());
        $reports = collect($reports);
        $models = $this->models;
        return (new KardexExport2)
            ->balance($balance)
            ->item_id($item_id)
            ->records($reports)
            ->models($models)
            ->company($company)
            ->establishment($establishment)
            ->download('ReporteKar' . Carbon::now() . '.xlsx');
    }
    public function getRecords2($request)
    {

        $item_id = $request['item_id'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];

        $records = $this->data2($item_id, $date_start, $date_end);

        return $records;
    }


    private function data2($item_id, $date_start, $date_end)
    {

        // $warehouse = Warehouse::where('establishment_id', auth()->user()->establishment_id)->first();

        if ($date_start && $date_end) {

            $data = ItemLotsGroup::whereBetween('date_of_due', [$date_start, $date_end])
                ->orderBy('item_id')->orderBy('id');
        } else {

            $data = ItemLotsGroup::orderBy('item_id')->orderBy('id');
        }

        if ($item_id) {
            $data = $data->where('item_id', $item_id);
        }


        return $data;
    }

    public function records_lots_kardex(Request $request)
    {
        $records = $this->getRecords2($request->all());

        return new ReportKardexLotsGroupCollection($records->paginate(config('tenant.items_per_page')));
    }


    public function getRecords3($request)
    {

        $item_id = $request['item_id'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];

        $records = $this->data3($item_id, $date_start, $date_end);

        return $records;
    }


    private function data3($item_id, $date_start, $date_end)
    {

        // $warehouse = Warehouse::where('establishment_id', auth()->user()->establishment_id)->first();

        if ($date_start && $date_end) {

            $data = ItemLot::whereBetween('date', [$date_start, $date_end])
                ->orderBy('item_id')->orderBy('id');
        } else {

            $data = ItemLot::orderBy('item_id')->orderBy('id');
        }

        if ($item_id) {
            $data = $data->where('item_id', $item_id);
        }


        return $data;
    }

    public function records_series_kardex(Request $request)
    {

        $records = $this->getRecords3($request->all());

        return new ReportKardexItemLotCollection($records->paginate(config('tenant.items_per_page')));

        /*$records = [];

        if($item)
        {
            $records  =  ItemLot::where('item_id', $item)->get();

        }
        else{
            $records  = ItemLot::all();
        }

       // $records  =  ItemLot::all();
        return new ReportKardexItemLotCollection($records);*/
    }




    // public function search(Request $request) {
    //     //return $request->item_selected;
    //     $balance = 0;
    //     $d = $request->d;
    //     $a = $request->a;
    //     $item_selected = $request->item_selected;

    //     $items = Item::query()->whereNotIsSet()
    //         ->where([['item_type_id', '01'], ['unit_type_id', '!=','ZZ']])
    //         ->latest()
    //         ->get();

    //     $warehouse = Warehouse::where('establishment_id', auth()->user()->establishment_id)->first();

    //     if($d && $a){

    //         $reports = InventoryKardex::with(['inventory_kardexable'])
    //                     ->where([['item_id', $request->item_selected],['warehouse_id', $warehouse->id]])
    //                     ->whereBetween('date_of_issue', [$d, $a])
    //                     ->orderBy('id')
    //                     ->paginate(config('tenant.items_per_page'));

    //     }else{

    //         $reports = InventoryKardex::with(['inventory_kardexable'])
    //                     ->where([['item_id', $request->item_selected],['warehouse_id', $warehouse->id]])
    //                     ->orderBy('id')
    //                     ->paginate(config('tenant.items_per_page'));

    //     }

    //     //return json_encode($reports);

    //     $models = $this->models;

    //     return view('inventory::reports.kardex.index', compact('items', 'reports', 'balance','models', 'a', 'd','item_selected'));
    // }

}
