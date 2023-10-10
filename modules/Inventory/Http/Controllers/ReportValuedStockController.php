<?php

namespace Modules\Inventory\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Tenant\Item;
use Illuminate\Http\Request;
use App\Models\Tenant\Company;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\ItemUnitType;
use App\Models\Tenant\ItemWarehouse;
use Modules\Inventory\Models\ListOrdenCompra;
use Modules\Inventory\Models\OrdenCompra;
use Illuminate\Support\Facades\Log;
use Modules\Inventory\Http\Resources\ReportValuedStockCollection;
use PhpParser\Node\Stmt\TryCatch;
use Modules\Report\Exports\StockMinExport;
use Modules\Report\Exports\StockValuedExport;

class ReportValuedStockController extends Controller
{
    public function index()
    {
        $stablecimientos = Establishment::all();
        $categoriaFoods = DB::connection('tenant')->select('select * from categories');


        return view('inventory::reports.valued.index')->with('stablecimientos', $stablecimientos)->with('resultArraycategoriaFoods', $categoriaFoods);
    }
    public function exportExcel(Request $request){
     

        $categoria_id = $request->categoria_id;
        $establishment_id = $request->establishment_id;
        $config = Configuration::first();
        $item_id_variation = $config->item_variation_id;
        $all_items = ItemWarehouse::query();
        if ($categoria_id) {
            $all_items = $all_items->whereHas('item', function ($query) use ($categoria_id) {
                $query->where('category_id', $categoria_id);
            });
        }

        if ($item_id_variation) {
            $all_items = $all_items->whereHas('item', function ($query) use ($item_id_variation) {
                $query->where('id', '<>', $item_id_variation);
            });
        }
        if($establishment_id){
            $all_items = $all_items->where('warehouse_id', $establishment_id);
        }
        $records = $all_items->get()->transform(function($row){
            $item = $row->item;

            return [

                        'id' => $item->id,
                        'description' => $item->description,
                        'stock' => $row->stock,
                        'unit_type' => $item->unit_type->description,
                        'unit_item' => $item->max_quantity_description,
                        'max_quantity_item' => $item->max_quantity,
                        'sale_unit_price' => $item->sale_unit_price,
                        'total' => $row->stock * $item->sale_unit_price,
                        'purchase_unit_price' => $item->purchase_unit_price,
                        'total_purchase' => $row->stock * $item->purchase_unit_price,
                        'gain' => $row->stock * $item->sale_unit_price - $row->stock * $item->purchase_unit_price,
                        'warehouse_id' => $row->warehouse_id,
                        'warehouse_description' => $row->warehouse->description,

            ];

        });
        $company = Company::find(1);

   
        

        $documento = (new StockValuedExport)
        ->company($company)
        ->records($records)
        ->download('ReporteVal' . Carbon::now() . '.xlsx');
        
        return $documento ;
    }

    public function report_cash(Request $request)
    {
        $categoria_id = $request->categoria_id;
        $establishment_id = $request->establishment_id;
        $config = Configuration::first();
        $item_id_variation = $config->item_variation_id;
        $all_items = ItemWarehouse::query();
        if ($categoria_id) {
            $all_items = $all_items->whereHas('item', function ($query) use ($categoria_id) {
                $query->where('category_id', $categoria_id);
            });
        }

        if ($item_id_variation) {
            $all_items = $all_items->whereHas('item', function ($query) use ($item_id_variation) {
                $query->where('id', '<>', $item_id_variation);
            });
        }
        if($establishment_id){
            $all_items = $all_items->where('warehouse_id', $establishment_id);
        }

       
        return new ReportValuedStockCollection($all_items->paginate(20));
    }
    public function report_cash_(Request $request)
    {
        $categoria_id = $request->categoria_id;

        $establishment_id = $request->establishment_id;
        $date_start = $request->date_start ? Carbon::parse($request->date_start)->format("y-m-d") : null;
        $date_end = $request->date_end ? Carbon::parse($request->date_end)->format("y-m-d") : null;
        $month = 11;
        $items = [];
        $total = 0;
        $total_items = 0;
        $config = Configuration::first();
        $item_id_variation = $config->item_variation_id;
        //total venta -> jalar documentos
        $recordsDocument = Item::query();
        if ($item_id_variation) {
            $recordsDocument = $recordsDocument->where('id', '<>', $item_id_variation);
        }

        //    if ($establishment_id) {
        //         $recordsDocument = $recordsDocument->whereHas('warehouses', function ($query) use ($establishment_id) {
        //             $query->where('warehouse_id', $establishment_id);
        //         });
        //     }
        $recordsDocument->chunk(50, function ($all_items)
        use (&$items, &$total, &$categoria_id, &$total_items) {

            foreach ($all_items as  $d_it) {

                if ($categoria_id == null) {
                    $item = $d_it;
                    $factor = null;
                    $unit_type = null;
                    $unit_item =  $d_it->unit_type->description;
                    $purchase_unit_price =  $d_it->purchase_unit_price;
                    $max_quantity_item = null;
                    if ($d_it->max_quantity) {
                        $max_quantity_item = $d_it->max_quantity;
                        $purchase_unit_price /= $d_it->max_quantity;
                        $uit = ItemUnitType::where('quantity_unit', $d_it->max_quantity)->where('item_id', $d_it->id)->first();
                        if ($uit) {
                            $unit_type = $uit->unit_type->description;
                        }
                    }
                    $unit_type_name = null;
                    $quantity = $d_it->stock;
                    // if (isset($item->has_unit_type)) {
                    //     $uit = ItemUnitType::where('description', $item->has_unit_type)->where('item_id', $d_it->id)->first();
                    //     if ($uit) {
                    //         $unit_type_name = $item->has_unit_type;
                    //         $factor = floatval($uit->quantity_unit);
                    //         $quantity *= $factor;
                    //     }
                    // }


                    $total += $d_it->total;
                    $total_items += $d_it->total;

                    $items[$d_it->id] = [
                        "description" => $d_it->description,
                        "count" => $quantity,
                        "purchase_unit_price" => $purchase_unit_price,
                        "total" => $d_it->sale_unit_price * $d_it->stock,
                        "unit_type" => $unit_type,
                        "factor" => $factor,
                        "max_quantity_item" => $max_quantity_item,
                        "unit_type_name" => $unit_type_name,
                        "unit_item" => $unit_item,
                        // "prices" => [
                        //     $d_it->unit_price => [
                        //         "count" =>  $d_it->quantity,
                        //         "factor" => $factor,
                        //         "unit_type_name" => $unit_type_name,
                        //     ]
                        // ],
                    ];
                } else {
                    //'categor8ia no es nulla '
                    $item = $d_it;

                    $itemCattegoria =  $d_it;

                    if ($itemCattegoria->category_id == $categoria_id) {
                        $factor = null;
                        $unit_type = null;
                        $unit_item =  $d_it->unit_type->description;
                        $purchase_unit_price =  $d_it->purchase_unit_price;
                        $max_quantity_item = null;
                        if ($d_it->max_quantity) {
                            $max_quantity_item = $d_it->max_quantity;
                            $purchase_unit_price /= $d_it->max_quantity;
                            $uit = ItemUnitType::where('quantity_unit', $d_it->max_quantity)->where('item_id', $d_it->id)->first();
                            if ($uit) {
                                $unit_type = $uit->unit_type->description;
                            }
                        }
                        $unit_type_name = null;
                        $quantity = $d_it->stock;
                        // if (isset($item->has_unit_type)) {
                        //     $uit = ItemUnitType::where('description', $item->has_unit_type)->where('item_id', $d_it->id)->first();
                        //     if ($uit) {
                        //         $unit_type_name = $item->has_unit_type;
                        //         $factor = floatval($uit->quantity_unit);
                        //         $quantity *= $factor;
                        //     }
                        // }


                        $total += $d_it->total;
                        $total_items += 1;

                        $items[$d_it->id] = [
                            "description" => $d_it->description,
                            "count" => $quantity,
                            "purchase_unit_price" => $purchase_unit_price,
                            "total" => $d_it->sale_unit_price * $d_it->stock,
                            "unit_type" => $unit_type,
                            "factor" => $factor,
                            "max_quantity_item" => $max_quantity_item,
                            "unit_type_name" => $unit_type_name,
                            "unit_item" => $unit_item,
                            // "prices" => [
                            //     $d_it->unit_price => [
                            //         "count" =>  $d_it->quantity,
                            //         "factor" => $factor,
                            //         "unit_type_name" => $unit_type_name,
                            //     ]
                            // ],
                        ];
                    }
                }
            }
        });

        return compact(
            'total',
            'items'
        );
        //
    }
}
