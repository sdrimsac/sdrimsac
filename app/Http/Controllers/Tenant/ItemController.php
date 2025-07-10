<?php

namespace App\Http\Controllers\Tenant;

use Exception;
use Mpdf\Mpdf;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemCategoriaMadera;
use App\Models\Tenant\CategoriaMadera;
use App\Models\Tenant\User;
use App\Models\Tenant\Company;
use Mpdf\HTMLParserMode;
use App\Models\Tenant\Inventory;
use App\Models\Tenant\ItemImage;
use App\Models\Tenant\Warehouse;
use App\Models\Tenant\ItemCodes;

use Illuminate\Support\Str;

use App\Imports\ItemsImport;
use App\Models\Tenant\Catalogs\Tag;
use App\Models\Tenant\DocumentItem;
use App\Models\Tenant\ItemUnitType;
use App\Models\Tenant\PurchaseItem;
use App\Models\Tenant\SaleNoteItem;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\ItemWarehouse;
use Modules\Item\Models\Brand;
use Modules\Item\Models\ItemLot;
use App\Models\Tenant\Catalogs\UnitType;
use App\Models\Tenant\PaymentMethodType;
use Modules\Item\Models\CategoryItem;
use App\Http\Requests\Tenant\ItemRequest;
use Modules\Format\Models\Account;
use Modules\Restaurant\Models\Area;
use Modules\Restaurant\Models\Food;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\ItemCatalogCollection;
use App\Http\Resources\Tenant\ItemClientCollection;
use App\Http\Resources\Tenant\ItemStockCollection;
use App\Http\Resources\Tenant\ItemResource;
use App\Models\Tenant\Catalogs\CurrencyType;
use App\Http\Resources\Tenant\ItemCollection;
use App\Http\Resources\Tenant\ItemUltima_Venta;
use App\Imports\ItemsPriceImport;
use App\Imports\ItemsStockImport;
use App\Models\Tenant\Catalogs\AttributeType;
use App\Models\Tenant\Catalogs\SystemIscType;
use Modules\Item\Models\ItemLotsGroup;
use Illuminate\Support\Facades\Storage;
use App\Models\Tenant\Catalogs\AffectationIgvType;
use App\Models\Tenant\CommercialTreatment;
use App\Models\Tenant\CommercialTreatmentItem;
use App\Models\Tenant\InventoryKardex;
use App\Models\Tenant\ItemColorSize;
use App\Models\Tenant\ItemWarehousePrice;
use App\Models\Tenant\Kardex;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Inventory\Models\Warehouse as WarehouseModule;
use Modules\Report\Exports\ItemClientProductExport;
use Modules\Report\Exports\ItemExport;
use Modules\Report\Exports\ItemExportGeneral;
use Modules\Report\Exports\ItemExportGeneralForImport;
use Modules\Report\Exports\ItemStockImportFormatExport;
use App\Models\Tenant\Document;
use App\Models\Tenant\Purchase;
use App\Http\Resources\Tenant\ItemUltima_ventaCollection;
use App\Http\Resources\Tenant\ItemUltima_CompraCollection;
use App\Models\Tenant\BonusUnitType;
use App\Http\Resources\Tenant\RegisterMovementCollection;
use App\Imports\ItemsPriceRangeImport;
use App\Imports\ItemsPriceRangeUnitTypeImport;
use App\Imports\ItemsStockImportList;
use App\Models\Tenant\ItemUnitTypePriceRange;
use App\Models\Tenant\ItemWarranty;
use App\Models\Tenant\RegisterMovement;
use App\Models\Tenant\SaleOffertDetail;
use Barryvdh\DomPDF\Facade as PDF;

class ItemController extends Controller
{
    protected $all_models = [];
    public function __construct()
    {
        $this->all_models = [

            "Item" => "App\Models\Tenant\Item",
        ];
    }
    public function getSaleOffert()
    {
        $sale_offert_details = SaleOffertDetail::all();
        return response()->json($sale_offert_details);
    }
    public function saveSaleOffert(Request $request)
    {
        $sale_offert_detail = SaleOffertDetail::create($request->all());
        return response()->json($sale_offert_detail);
    }
    public function updateSaleOffert(Request $request)
    {
        $sale_offert_detail = SaleOffertDetail::find($request->id);
        $sale_offert_detail->update($request->all());
        return response()->json($sale_offert_detail);
    }
    public function deleteSaleOffert(Request $request)
    {
        $sale_offert_detail = SaleOffertDetail::find($request->id);
        $sale_offert_detail->delete();
        return response()->json($sale_offert_detail);
    }
    public function importStockFormat(Request $request)
    {
        $warehouse_id = $request->warehouse_id;
        $items =  Item::select('internal_id', 'description')
            ->whereHas('warehouses', function ($q) use ($warehouse_id) {
                $q->where('warehouse_id', $warehouse_id);
            })
            ->get();
        $description_warehouse = Warehouse::find($warehouse_id)->description;

        return (new ItemStockImportFormatExport)
            ->items($items)
            ->download('Productos_de_' . $description_warehouse . '_' . Carbon::now() . '.xlsx');
    }
    public function importStock(Request $request)
    {
        if ($request->hasFile('file')) {
            try {
                $import = new ItemsStockImport();
                $import->setWarehouseId($request->warehouse_id);
                $import->import($request->file('file'), null, Excel::XLSX);
                $data = $import->getData();
                return [
                    'success' => true,
                    'message' =>  __('app.actions.upload.success'),
                    'data' => $data
                ];
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' =>  $e->getMessage()
                ];
            }
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }
    public function importStockList(Request $request)
    {
        if ($request->hasFile('file')) {
            try {
                $import = new ItemsStockImportList();
                $import->setWarehouseId($request->warehouse_id);
                $import->import($request->file('file'), null, Excel::XLSX);
                $data = $import->getData();
                return [
                    'success' => true,
                    'message' =>  __('app.actions.upload.success'),
                    'data' => $data
                ];
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' =>  $e->getMessage()
                ];
            }
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }

    public function updatePriceUnitType(Request $request)
    {
        $price = $request->sale_unit_price;
        $type_id = $request->unit_type_id;

        $item_unit_type = ItemUnitType::find($type_id);
        $item_unit_type->price2 = $price / $item_unit_type->quantity_unit;
        $item_unit_type->total = $price;
        $item_unit_type->save();
        return [
            'success' => true,
            'message' => 'Se actualizó el precio del producto'
        ];
    }
    public function updatePriceCommercialTreatment(Request $request)
    {
        $commercial_treatment_id = $request->commercial_treatment_id;
        $item_id = $request->item_id;
        $price = $request->sale_unit_price;
        $commercial_treatment_item = CommercialTreatmentItem::where('commercial_treatment_id', $commercial_treatment_id)
            ->where('item_id', $item_id)
            ->first();

        if ($commercial_treatment_item) {
            $commercial_treatment_item->price = $price;
            $commercial_treatment_item->save();
        } else {
            $commercial_treatment_item = new CommercialTreatmentItem();
            $commercial_treatment_item->commercial_treatment_id = $commercial_treatment_id;
            $commercial_treatment_item->item_id = $item_id;
            $commercial_treatment_item->amount = $price;
            $commercial_treatment_item->active = true;
            $commercial_treatment_item->save();
        }

        return [
            'success' => true,
            'message' => 'Se actualizó el precio del producto'
        ];
    }
    public function updatePriceItem(Request $request)
    {
        $item = Item::findOrFail($request->item_id);
        $item->sale_unit_price = $request->sale_unit_price;
        $food = Food::where('item_id', $item->id)->first();
        $food->price = $request->sale_unit_price;
        $food->save();
        //de itemwarehouse seleccionar los que tengan el warehouse_id en 1 y stock menor a 0 y actualiza rel stock a 0
        $item_warehouse = ItemWarehouse::where('warehouse_id', 1)
            ->where('stock', '<', 0)
            ->update(['stock' => 0]);
        $establishment_id = auth()->user()->establishment_id;
        $warehouse_id = Warehouse::where('establishment_id', $establishment_id)->first()->id;
        ItemWarehousePrice::where('item_id', $item->id)
            ->where('warehouse_id', $warehouse_id)
            ->update(['price' => $request->sale_unit_price]);

        $item->save();
        return [
            'success' => true,
            'message' => 'Se actualizó el precio del producto'
        ];
    }
    public function index_product_client()
    {
        return view('tenant.items.index_product_client');
    }
    public function items_by_clients_excel(Request $request)
    {

        ini_set('memory_limit', '2048M');
        set_time_limit(0);
        ini_set('max_execution_time', 0);

        $categoria_id = $request->categoria_id;
        $item_id = $request->item_id;
        $establishment_id = $request->establishment_id;
        $date_start = $request->date_start ? Carbon::parse($request->date_start)->format("y-m-d") : null;
        $customer_id = $request->customer_id;
        $date_end = $request->date_end ? Carbon::parse($request->date_end)->format("y-m-d") : null;


        $document_items = DocumentItem::whereIn('state_type_id', ['01', '03', '05']);
        $sale_note_items = SaleNoteItem::whereIn('state_type_id', ['01', '03', '05']);

        if ($item_id) {
            $document_items->where('item_id', $item_id);
            $sale_note_items->where('item_id', $item_id);
        }
        if ($categoria_id) {
            $document_items->whereHas('item', function ($q) use ($categoria_id) {
                $q->where('category_id', $categoria_id);
            });
            $sale_note_items->whereHas('item', function ($q) use ($categoria_id) {
                $q->where('category_id', $categoria_id);
            });
        }
        if ($establishment_id) {
            $document_items->whereHas('document', function ($q) use ($establishment_id) {
                $q->where('establishment_id', $establishment_id);
            });
            $sale_note_items->whereHas('sale_note', function ($q) use ($establishment_id) {
                $q->where('establishment_id', $establishment_id);
            });
        }
        if ($customer_id) {
            $document_items->whereHas('document', function ($q) use ($customer_id) {
                $q->where('customer_id', $customer_id);
            });
            $sale_note_items->whereHas('sale_note', function ($q) use ($customer_id) {
                $q->where('customer_id', $customer_id);
            });
        }
        if ($date_start && $date_end) {
            $document_items->whereHas('document', function ($q) use ($date_start, $date_end) {
                $q->whereBetween('date_of_issue', [$date_start, $date_end]);
            });
            $sale_note_items->whereHas('sale_note', function ($q) use ($date_start, $date_end) {
                $q->whereBetween('date_of_issue', [$date_start, $date_end]);
            });
        } else if ($date_start) {
            $document_items->whereHas('document', function ($q) use ($date_start) {
                $q->where('date_of_issue', '>=', $date_start);
            });
            $sale_note_items->whereHas('sale_note', function ($q) use ($date_start) {
                $q->where('date_of_issue', '>=', $date_start);
            });
        }

        $document_items->select(
            'documents.customer_id',
            'documents.series',
            'documents.date_of_issue',
            'documents.number',
            DB::raw('SUM(document_items.quantity) as total_quantity'),
            'document_items.item_id',
            'document_items.total',
            'persons.name as customer_name',
            'persons.number as customer_number',
            'items.description as item_description',
            DB::raw('JSON_UNQUOTE(JSON_EXTRACT(document_items.item, "$.categoriaMadera.selectedAncho")) as selectedAncho'),
            DB::raw('JSON_UNQUOTE(JSON_EXTRACT(document_items.item, "$.categoriaMadera.selectedLargo")) as selectedLargo'),
            DB::raw('JSON_UNQUOTE(JSON_EXTRACT(document_items.item, "$.categoriaMadera.selectedGrosor")) as selectedGrosor')
        )
            ->join('documents', 'document_items.document_id', '=', 'documents.id')
            ->join('persons', 'documents.customer_id', '=', 'persons.id')
            //join con item
            ->join('items', 'document_items.item_id', '=', 'items.id')
            // ->where('documents.establishment_id', '=', $establishment_id)
            ->groupBy(
                'documents.customer_id',
                'document_items.item_id',
                'persons.name',
                'persons.number',
                'documents.series',
                'documents.number',
                'document_items.total',
                'documents.date_of_issue',
                'selectedAncho',
                'selectedLargo',
                'selectedGrosor'
            );

        $sale_note_items->select(
            'sale_notes.customer_id',
            'sale_notes.series',
            'sale_notes.date_of_issue',
            'sale_notes.number',
            DB::raw('SUM(sale_note_items.quantity) as total_quantity'),
            'sale_note_items.item_id',
            'sale_note_items.total',
            'persons.name as customer_name',
            'persons.number as customer_number',
            'items.description as item_description',
            DB::raw('JSON_UNQUOTE(JSON_EXTRACT(sale_note_items.item, "$.categoriaMadera.selectedAncho")) as selectedAncho'),
            DB::raw('JSON_UNQUOTE(JSON_EXTRACT(sale_note_items.item, "$.categoriaMadera.selectedLargo")) as selectedLargo'),
            DB::raw('JSON_UNQUOTE(JSON_EXTRACT(sale_note_items.item, "$.categoriaMadera.selectedGrosor")) as selectedGrosor')
        )
            ->join('sale_notes', 'sale_note_items.sale_note_id', '=', 'sale_notes.id')
            ->join('persons', 'sale_notes.customer_id', '=', 'persons.id') // Agrega la relación con la tabla "persons"
            //join con item
            ->join('items', 'sale_note_items.item_id', '=', 'items.id')
            // ->where('sale_notes.establishment_id', '=', $establishment_id)
            ->groupBy(
                'sale_notes.customer_id',
                'sale_note_items.item_id',
                'persons.name',
                'persons.number',
                'sale_notes.series',
                'sale_notes.number',
                'sale_note_items.total',
                'sale_notes.date_of_issue',
                'selectedAncho',
                'selectedLargo',
                'selectedGrosor'
            );

        // Combina las consultas de DocumentItem y SaleNoteItem
        $combined_items = $document_items->union($sale_note_items);

        $combined_items->groupBy('customer_id');

        $result = $combined_items->orderBy('customer_id');

        // return new ItemClientCollection($result->paginate(50));
        $items = $result->get();
        $establishment = null;
        if ($establishment_id) {
            $establishment = Establishment::find($establishment_id);
        }
        $company = Company::first();
        return (new ItemClientProductExport)
            ->establishment($establishment)
            ->company($company)
            ->items($items)
            ->date_start($date_start)
            ->date_end($date_end)
            ->download('Reporte_productos_por_clientes' . Carbon::now() . '.xlsx');
    }
    public function items_by_clients(Request $request)
    {
        $categoria_id = $request->categoria_id;
        $item_id = $request->item_id;
        $establishment_id = $request->establishment_id;
        $date_start = $request->date_start ? Carbon::parse($request->date_start)->format("y-m-d") : null;
        $customer_id = $request->customer_id;
        $date_end = $request->date_end ? Carbon::parse($request->date_end)->format("y-m-d") : null;


        $document_items = DocumentItem::whereIn('state_type_id', ['01', '03', '05']);
        $sale_note_items = SaleNoteItem::whereIn('state_type_id', ['01', '03', '05']);

        if ($item_id) {
            $document_items->where('item_id', $item_id);
            $sale_note_items->where('item_id', $item_id);
        }
        if ($categoria_id) {
            $document_items->whereHas('item', function ($q) use ($categoria_id) {
                $q->where('category_id', $categoria_id);
            });
            $sale_note_items->whereHas('item', function ($q) use ($categoria_id) {
                $q->where('category_id', $categoria_id);
            });
        }
        if ($establishment_id) {
            $document_items->whereHas('document', function ($q) use ($establishment_id) {
                $q->where('establishment_id', $establishment_id);
            });
            $sale_note_items->whereHas('sale_note', function ($q) use ($establishment_id) {
                $q->where('establishment_id', $establishment_id);
            });
        }
        if ($customer_id) {
            $document_items->whereHas('document', function ($q) use ($customer_id) {
                $q->where('customer_id', $customer_id);
            });
            $sale_note_items->whereHas('sale_note', function ($q) use ($customer_id) {
                $q->where('customer_id', $customer_id);
            });
        }
        if ($date_start && $date_end) {
            $document_items->whereHas('document', function ($q) use ($date_start, $date_end) {
                $q->whereBetween('date_of_issue', [$date_start, $date_end]);
            });
            $sale_note_items->whereHas('sale_note', function ($q) use ($date_start, $date_end) {
                $q->whereBetween('date_of_issue', [$date_start, $date_end]);
            });
        } else if ($date_start) {
            $document_items->whereHas('document', function ($q) use ($date_start) {
                $q->where('date_of_issue', '>=', $date_start);
            });
            $sale_note_items->whereHas('sale_note', function ($q) use ($date_start) {
                $q->where('date_of_issue', '>=', $date_start);
            });
        }

        $document_items->select(
            'documents.customer_id',
            'documents.series',
            'documents.date_of_issue',
            'documents.number',
            DB::raw('SUM(document_items.quantity) as total_quantity'),
            'document_items.item_id',
            'document_items.total',
            'persons.name as customer_name',
            'persons.number as customer_number',
            'items.description as item_description',
            DB::raw('JSON_UNQUOTE(JSON_EXTRACT(document_items.item, "$.categoriaMadera.selectedAncho")) as selectedAncho'),
            DB::raw('JSON_UNQUOTE(JSON_EXTRACT(document_items.item, "$.categoriaMadera.selectedLargo")) as selectedLargo'),
            DB::raw('JSON_UNQUOTE(JSON_EXTRACT(document_items.item, "$.categoriaMadera.selectedGrosor")) as selectedGrosor')
        )
            ->join('documents', 'document_items.document_id', '=', 'documents.id')
            ->join('persons', 'documents.customer_id', '=', 'persons.id')
            //join con item
            ->join('items', 'document_items.item_id', '=', 'items.id')
            ->groupBy(
                'documents.customer_id',
                'document_items.item_id',
                'persons.name',
                'persons.number',
                'documents.series',
                'documents.number',
                'document_items.total',
                'documents.date_of_issue',
                'selectedAncho',
                'selectedLargo',
                'selectedGrosor'
            );

        $sale_note_items->select(
            'sale_notes.customer_id',
            'sale_notes.series',
            'sale_notes.date_of_issue',
            'sale_notes.number',
            DB::raw('SUM(sale_note_items.quantity) as total_quantity'),
            'sale_note_items.item_id',
            'sale_note_items.total',
            'persons.name as customer_name',
            'persons.number as customer_number',
            'items.description as item_description',
            DB::raw('JSON_UNQUOTE(JSON_EXTRACT(sale_note_items.item, "$.categoriaMadera.selectedAncho")) as selectedAncho'),
            DB::raw('JSON_UNQUOTE(JSON_EXTRACT(sale_note_items.item, "$.categoriaMadera.selectedLargo")) as selectedLargo'),
            DB::raw('JSON_UNQUOTE(JSON_EXTRACT(sale_note_items.item, "$.categoriaMadera.selectedGrosor")) as selectedGrosor')
        )
            ->join('sale_notes', 'sale_note_items.sale_note_id', '=', 'sale_notes.id')
            ->join('persons', 'sale_notes.customer_id', '=', 'persons.id') // Agrega la relación con la tabla "persons"
            //join con item
            ->join('items', 'sale_note_items.item_id', '=', 'items.id')
            // ->where('sale_notes.establishment_id', '=', $establishment_id)
            ->groupBy(
                'sale_notes.customer_id',
                'sale_note_items.item_id',
                'persons.name',
                'persons.number',
                'sale_notes.series',
                'sale_notes.number',
                'sale_note_items.total',
                'sale_notes.date_of_issue',
                'selectedAncho',
                'selectedLargo',
                'selectedGrosor'
            );

        // Combina las consultas de DocumentItem y SaleNoteItem
        $combined_items = $document_items->union($sale_note_items);

        $combined_items->groupBy('customer_id');

        $result = $combined_items->orderBy('customer_id');

        // return new ItemClientCollection($result->paginate(50));
        return $result->get();
    }


    public function index()
    {

        return view('tenant.items.index');
    }

    public function index_ecommerce()
    {
        return view('tenant.items_ecommerce.index');
    }
    public function index_catalog()
    {
        return view('tenant.items.catalog');
    }

    public function check_series()
    {

        Item::where('series_enabled', true)->chunk(50, function ($items_chunk) {
            foreach ($items_chunk as $item) {
                $item->checkSeries();
            }
        });

        return [
            'success' => true,
            'message' => 'Se verificaron las series'
        ];
    }

    public function replicateAllPolicies()
    {
        try {
            DB::connection('tenant')->beginTransaction();

            $warehouse_ids = Warehouse::pluck('id')->toArray();

            $existing_policies = ItemUnitType::whereNotNull('warehouse_id')
                ->select('item_id', 'warehouse_id', 'unit_type_id')
                ->get()
                ->map(function ($item) {
                    return $item->item_id . '-' . $item->warehouse_id . '-' . $item->unit_type_id;
                })
                ->toArray();

            $all_policies = ItemUnitType::whereNotNull('warehouse_id')->get();

            $created_count = 0;

            foreach ($all_policies as $policy) {
                foreach ($warehouse_ids as $warehouse_id) {

                    if ($policy->warehouse_id == $warehouse_id) {
                        continue;
                    }

                    $policy_key = $policy->item_id . '-' . $warehouse_id . '-' . $policy->unit_type_id;

                    if (!in_array($policy_key, $existing_policies)) {

                        $new_policy = new ItemUnitType();
                        $new_policy->item_id = $policy->item_id;
                        $new_policy->unit_type_id = $policy->unit_type_id;
                        $new_policy->description = $policy->description;
                        $new_policy->warehouse_id = $warehouse_id;
                        $new_policy->quantity_unit = $policy->quantity_unit;
                        $new_policy->price1 = $policy->price1;
                        $new_policy->price2 = $policy->price2;
                        $new_policy->price3 = $policy->price3;
                        $new_policy->price_default = $policy->price_default;
                        $new_policy->total = $policy->total;
                        $new_policy->qty_min = $policy->qty_min;
                        $new_policy->qty_free = $policy->qty_free;
                        $new_policy->has_promotion = $policy->has_promotion;
                        $new_policy->qty_max = $policy->qty_max;
                        $new_policy->save();

                        // Replicate price ranges if they exist
                        foreach ($policy->item_unit_type_price_ranges as $range) {
                            $new_range = $range->replicate();
                            $new_range->item_unit_type_id = $new_policy->id;
                            $new_range->save();
                        }

                        Log::info("Nueva política replicada al almacén {$warehouse_id} para el item {$policy->item_id}");
                        $created_count++;
                    }
                }
            }

            DB::connection('tenant')->commit();

            return [
                'success' => true,
                'message' => "Se replicaron {$created_count} políticas a otros almacenes exitosamente"
            ];
        } catch (Exception $e) {
            DB::connection('tenant')->rollBack();
            Log::error($e->getMessage());

            return [
                'success' => false,
                'message' => 'Error al replicar las políticas: ' . $e->getMessage()
            ];
        }
    }

    public function addProductToPolitica($item_id)
    {
        try {

            $policies = ItemUnitType::where('item_id', $item_id)->get();

            if ($policies->count() > 0) {

                $warehouses = Warehouse::all();
                $created_count = 0;

                foreach ($warehouses as $warehouse) {
                    foreach ($policies as $policy) {

                        $exists = ItemUnitType::where([
                            'item_id' => $item_id,
                            'warehouse_id' => $warehouse->id,
                            'unit_type_id' => $policy->unit_type_id,
                            'description' => $policy->description
                        ])->exists();

                        if (!$exists) {
                            $new_policy = $policy->replicate();
                            $new_policy->warehouse_id = $warehouse->id;
                            $new_policy->save();

                            foreach ($policy->item_unit_type_price_ranges as $range) {
                                $new_range = $range->replicate();
                                $new_range->item_unit_type_id = $new_policy->id;
                                $new_range->save();
                            }

                            $created_count++;
                        }
                    }
                }

                return [
                    'success' => true,
                    'message' => "Se replicaron {$policies->count()} políticas en los nuevos almacenes exitosamente"
                ];
            }

            return [
                'success' => true,
                'message' => 'El producto no tiene políticas de precios para replicar'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al replicar políticas de precios: ' . $e->getMessage()
            ];
        }
    }

    public function addProductToWarehouses($item_id)
    {
        try {
            $item = Item::find($item_id);
            $warehouses = Warehouse::all();
            $created_count = 0;

            foreach ($warehouses as $warehouse) {
                // Verificar si ya existe el registro
                $exists = ItemWarehouse::where('item_id', $item->id)
                    ->where('warehouse_id', $warehouse->id)
                    ->exists();

                // Solo crear si no existe
                if (!$exists) {
                    ItemWarehouse::create([
                        'item_id' => $item->id,
                        'warehouse_id' => $warehouse->id,
                        'stock' => 0,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    $created_count++;
                }
            }

            return [
                'success' => true,
                'message' => "Se agregó el producto a {$created_count} almacenes nuevos"
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al agregar el producto a los almacenes: ' . $e->getMessage()
            ];
        }
    }
    public function addProductsToWarehouses()
    {
        try {
            DB::connection('tenant')->beginTransaction();

            // Obtener todos los IDs de almacenes
            $warehouse_ids = Warehouse::pluck('id')->toArray();

            // Obtener las combinaciones existentes de item_id y warehouse_id
            $existing_combinations = ItemWarehouse::select('item_id', 'warehouse_id')
                ->get()
                ->map(function ($item) {
                    return $item->item_id . '-' . $item->warehouse_id;
                })
                ->toArray();

            // Procesar items en chunks y preparar inserciones masivas
            Item::chunk(500, function ($items) use ($warehouse_ids, $existing_combinations) {
                $records_to_insert = [];

                foreach ($items as $item) {
                    foreach ($warehouse_ids as $warehouse_id) {
                        // Verificar si la combinación ya existe
                        if (!in_array($item->id . '-' . $warehouse_id, $existing_combinations)) {
                            $records_to_insert[] = [
                                'item_id' => $item->id,
                                'warehouse_id' => $warehouse_id,
                                'stock' => 0,
                                'created_at' => now(),
                                'updated_at' => now()
                            ];
                        }
                    }
                }

                // Insertar en lotes si hay registros
                if (!empty($records_to_insert)) {
                    ItemWarehouse::insert($records_to_insert);
                }
            });

            DB::connection('tenant')->commit();

            return [
                'success' => true,
                'message' => 'Productos agregados correctamente a todos los almacenes'
            ];
        } catch (Exception $e) {
            DB::connection('tenant')->rollBack();
            Log::error($e->getMessage());

            return [
                'success' => false,
                'message' => 'Error al agregar productos a los almacenes: ' . $e->getMessage()
            ];
        }
    }

    public function columns()
    {
        return [
            'description' => 'Nombre | Cód. Int. | Nombre Sec. ',
            'category' => 'Categoria',
            'barcode' => 'Código de barras',
            'brand' => 'Marca',
            'date_of_due' => 'Fecha vencimiento',
            'warranty' => 'meses garantía',
            'lot_code' => 'Código lote',
            'code_barcode' => 'Código de busqueda',
            // 'description' => 'Descripción'
        ];
    }
    /* public function columns2()
    {
        return [
            'active' => 'Habilitados',
            'inactive' => 'Inhabilitados',
        ];
    } */
    // public function generateCode()
    // {
    //     $new_code = "100001";
    //     $item = Item::whereRaw('LENGTH(internal_id) >= 6')->where('internal_id', 'regexp', '^[0-9]{6,}$')->orderBy('internal_id', 'desc')->first();

    //     if ($item) {
    //         $internal_id = $item->internal_id;
    //         $new_code = str_pad(intval($internal_id) + 1, 6, '0', STR_PAD_LEFT);
    //     }

    //     return $new_code;
    // }
    public function generateCode()
    {
        $regex = '/^\d+$/';
        $new_code = "";
        $item = Item::where('internal_id', 'regexp', '^1[0-9]{5}$')->orderBy('internal_id', 'desc')->first();
        if (!$item) {
            $new_code = "100001";
        } else {
            $internal_id = $item->internal_id;
            if (preg_match($regex, $internal_id) === 1) {
                $new_code = intval($internal_id) + 1;
            } else {
                $new_code = "100001";
            }
        }
        return $new_code;
    }
    public function tablesImport()
    {
        $user = auth()->user();
        $warehouses = Warehouse::select('id', 'description');
        //
        if ($user->type !== 'admin' || $user->type !== 'superadmin') {
            //$warehouses = $warehouses->whereNotIn('id', [0]);
        }

        return response()->json([
            'warehouses' => $warehouses->get(),
        ], 200);
    }

    public function filterByCategory(Request $request)
    {
        $category_id = $request->input('category_id');
        $items = Item::where('category_id', $category_id);
        return new ItemCollection($items->paginate(config('tenant.items_per_page')));
    }
    public function filtercategory($filtercategory)
    {
        $items = Item::where('category_id', '=', $filtercategory)->get();
        return new ItemCollection($items);
    }
    public function records(Request $request)
    {
        $records = $this->getRecords($request);
        return new ItemCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function recordsMobile(Request $request)
    {
        $records = $this->getRecordMobile($request);
        return new ItemCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function recordsCatalog(Request $request)
    {
        $records = $this->getRecordsCatalog($request);

        return new ItemCatalogCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function recordsUltima_Venta(Request $request, $id)
    {
        $records = $this->getRecordsUltima_Venta($id);

        return new ItemUltima_ventaCollection($records->paginate(5));
    }

    public function recordsUltima_Compra(Request $request, $id)
    {
        $records = $this->getRecordsUltima_compra($request, $id);

        return new ItemUltima_CompraCollection($records->paginate(5));
    }

    public function updateprice(Request $request)
    {

        $record = Item::findOrFail($request->id);
        $record->sale_unit_price = $request->sale_unit_price;
        $record->save();
        return [
            "success" => true,
            "message" => "Se actualizo con Exito"
        ];
    }
    public function init_categories()
    {
        //regresa una array de array donde este 'category' con el nombre de cateogria y 'items' con los items 15 items de esa categoria

        $categories = CategoryItem::all();
        $categories_array = [];
        foreach ($categories as $category) {
            $items = Item::where('category_id', $category->id)->take(15)->get();
            $categories_array[] = [
                'category' => $category,
                'products' => $items
            ];
        }
        return $categories_array;
    }

    public function storeCatalog(Request $request)
    {
        $products = $request->input('products');
        $category_id = $request->input('category_id');
        $warehouse_id = $request->input('warehouse_id') ?? 1; // Default warehouse_id is 1

        if (!empty($products)) {
            DB::connection('tenant')->table('item_catalog')->truncate();

            $inserts = array_map(function ($product_id) {
                return [
                    'id_item_catalog' => $product_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }, $products);

            DB::connection('tenant')->table('item_catalog')->insert($inserts);
        }

        $catalog_ids = DB::connection('tenant')->table('item_catalog')
            ->pluck('id_item_catalog')
            ->toArray();

        $items = Item::whereTypeUser()
            ->whereNotIsSet()
            ->where('active', 1)
            ->whereNotIn('id', $catalog_ids)
            ->whereExists(function ($query) use ($warehouse_id) {
                $query->select(DB::raw(1))
                    ->from('item_warehouse')
                    ->whereColumn('item_warehouse.item_id', 'items.id')
                    ->where('item_warehouse.warehouse_id', $warehouse_id)
                    ->where('item_warehouse.active', 1);
            });

        if ($category_id) {
            $items = $items->where('category_id', $category_id);
        }

        return new ItemCatalogCollection($items->get());
    }

    public function getRecordsCatalog($request, $services = true)
    {
        $records = Item::whereTypeUser()
            ->whereNotIsSet();

        /** @var User $user */
        $user = auth()->user();
        $type = $user->getUserTypeArca();

        if (!$services) {
            $records = $records->where('unit_type_id', '!=', 'ZZ');
        }

        if ($type) {
            $records = $records->whereHas('warehouse', function ($query) use ($type) {
                $query->whereHas('establishment', function ($query) use ($type) {
                    if ($type == 'product') {
                        $query->where('is_product', 1);
                    } elseif ($type == 'service') {
                        $query->where('is_service', 1);
                    }
                });
            });
        }

        if ($request->category_id) {
            $records = $records->where('category_id', $request->category_id);
        }

        if ($request->description) {
            $search = $request->description;
            $records->where(function ($query) use ($search) {
                $query->where('description', 'like', "%{$search}%")
                    ->orWhere('internal_id', 'like', "%{$search}%");
            });
        }

        if ($request->warehouse_id) {
            if ($request->active !== null) {
                $active = ($request->active === 'Habilitado') ? 1 : 0;

                $records = $records->whereHas('warehouses', function ($query) use ($request, $active) {
                    $query->where('warehouse_id', $request->warehouse_id)
                        ->where('active', $active);
                });
            } else {
                $records = $records->whereHas('warehouses', function ($query) use ($request) {
                    $query->where('warehouse_id', $request->warehouse_id)
                        ->where('active', 1);
                });
            }
        }

        return $records->orderBy('description', 'ASC');
    }

    public function getRecordsInfo(Request $request)
    {
        $catalog_ids = DB::connection('tenant')->table('item_catalog')
            ->select('id_item_catalog')
            ->get()
            ->pluck('id_item_catalog')
            ->toArray();

        return $catalog_ids;
    }

    public function getRecords($request, $services = true)
    {
        $datos = $request->value;
        $textoIntoArray =  explode(' ', $datos);
        $warehouse_id = $request->warehouse_id;
        $categoria_madera_id = $request->categoria_madera_id;
        $area_id = $request->area_id;
        $active = $request->active;
        $records = Item::whereTypeUser()
            ->whereNotIsSet();
        /** @var User $user */
        $user = auth()->user();
        $type = $user->getUserTypeArca();
        if (!$services) {
            $records = $records->where('unit_type_id', '!=', 'ZZ');
        }
        if ($type) {
            $records = $records->whereHas('warehouse', function ($query) use ($type) {
                $query->whereHas('establishment', function ($query) use ($type) {
                    if ($type == 'product') {
                        $query->where('is_product', 1);
                    } elseif ($type == 'service') {
                        $query->where('is_service', 1);
                    }
                });
            });
        }
        switch ($request->column) {

            case 'brand':
                $records->whereHas('brand', function ($q) use ($request) {
                    $q->where('name', 'like', "%{$request->value}%");
                });
                break;
            case 'code_barcode':
                $records->whereHas('item_codes', function ($q) use ($request) {
                    $q->where('code_barcode', $request->value);
                });
                break;
            case 'description':
                if ($request->value) {
                    if (count($textoIntoArray) === 1) {
                        $records->where(function ($query) use ($textoIntoArray) {
                            foreach ($textoIntoArray as $value) {
                                $query->orWhere('description', 'like', '%' . $value . '%');
                            }
                        })
                            ->orWhere('internal_id', 'like', "%{$request->value}%")
                            ->orWhere('second_name', 'like', "%{$request->value}%")
                            ->orWhere('barcode', 'like', "%{$request->value}%")
                            ->orWhere('active', 'like', "%{$request->value}%");
                    } else {
                        $records->where(function ($query) use ($textoIntoArray) {
                            foreach ($textoIntoArray as $value) {
                                $query->where('description', 'like', '%' . $value . '%');
                            }
                        })
                            ->orWhere('internal_id', 'like', "%{$request->value}%")
                            ->orWhere('second_name', 'like', "%{$request->value}%")
                            ->orWhere('barcode', 'like', "%{$request->value}%")
                            ->orWhere('active', 'like', "%{$request->value}%");
                    }

                    $records->orderByRaw("description LIKE ? DESC", ["{$request->value}%"])
                        ->orderByRaw("description LIKE ? DESC", ["%{$request->value}%"])
                        ->orderBy('description', 'ASC');
                }
                break;

            case 'category':
                $records
                    ->whereHas('category', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->value . '%');
                    });
                break;
            default:
                $records
                    ->where($request->column, 'like', "%{$request->value}%");
                break;
        }

        $records = $records->where('active', 1);

        if ($active !== null) {
            $active = ($active === 'Habilitado') ? 1 : 0;

            $records = $records->whereHas('warehouses', function ($query) use ($warehouse_id, $active) {
                $query->where('warehouse_id', $warehouse_id)
                    ->where('active', $active);
            });
        } else {
            $records = $records->whereHas('warehouses', function ($query) use ($warehouse_id) {
                $query->where('warehouse_id', $warehouse_id)
                    ->where('active', 1);
            });
        }

        if ($categoria_madera_id) {
            $records = $records->whereHas('categoria_madera', function ($query) use ($categoria_madera_id) {
                $query->where('id', $categoria_madera_id);
            });
        }

        if ($area_id) {
            $records = $records->whereHas('food', function ($query) use ($area_id) {
                $query->where('area_id', $area_id);
            });
        }
        if ($warehouse_id) {
            $records = $records->with(['warehouses' => function ($query) use ($warehouse_id) {
                $query->where('warehouse_id', $warehouse_id);
            }]);
        }
        if ($warehouse_id) {
            $records = $records->with(['item_warehouse_prices' => function ($query) use ($warehouse_id) {
                $query->where('warehouse_id', $warehouse_id);
            }]);
        }

        return $records->orderBy('description', 'ASC');
    }
    public function getRecordMobile($request, $services = true)
    {
        $datos = $request->value;
        $textoIntoArray = explode(' ', $datos);
        $warehouse_id = $request->warehouse_id;
        $categoria_madera_id = $request->categoria_madera_id;
        $area_id = $request->area_id;
        $active = $request->active;

        $records = Item::whereTypeUser()
            ->whereNotIsSet();

        /** @var User $user */
        $user = auth()->user();
        $type = $user->getUserTypeArca();

        if (!$services) {
            $records = $records->where('unit_type_id', '!=', 'ZZ');
        }

        if ($type) {
            $records = $records->whereHas('warehouse', function ($query) use ($type) {
                $query->whereHas('establishment', function ($query) use ($type) {
                    if ($type == 'product') {
                        $query->where('is_product', 1);
                    } elseif ($type == 'service') {
                        $query->where('is_service', 1);
                    }
                });
            });
        }

        // 🔍 Filtros por descripción, código, etc.
        if ($request->value) {
            $records->where(function ($query) use ($request, $textoIntoArray) {
                $query->where('internal_id', 'like', "%{$request->value}%")
                    ->orWhere('second_name', 'like', "%{$request->value}%")
                    ->orWhere('barcode', 'like', "%{$request->value}%");

                if (count($textoIntoArray) === 1) {
                    foreach ($textoIntoArray as $value) {
                        $query->orWhere('description', 'like', '%' . $value . '%');
                    }
                } else {
                    foreach ($textoIntoArray as $value) {
                        $query->where('description', 'like', '%' . $value . '%');
                    }
                }
            });

            // Ordenamiento por coincidencia
            $records->orderByRaw("description LIKE ? DESC", ["{$request->value}%"])
                ->orderByRaw("description LIKE ? DESC", ["%{$request->value}%"]);
        }

        $records = $records->where('active', 1);

        // 🔒 Filtrado por almacén y estado activo
        if ($active !== null) {
            $active = ($active === 'Habilitado') ? 1 : 0;

            $records = $records->whereHas('warehouses', function ($query) use ($warehouse_id, $active) {
                $query->where('warehouse_id', $warehouse_id)
                    ->where('active', $active);
            });
        } elseif ($warehouse_id) {
            $records = $records->whereHas('warehouses', function ($query) use ($warehouse_id) {
                $query->where('warehouse_id', $warehouse_id)
                    ->where('active', 1);
            });
        }

        // 🪵 Filtrado por categoría madera (si aplica)
        if ($categoria_madera_id) {
            $records = $records->whereHas('categoria_madera', function ($query) use ($categoria_madera_id) {
                $query->where('id', $categoria_madera_id);
            });
        }

        // 🍽 Filtrado por área de comida (si aplica)
        if ($area_id) {
            $records = $records->whereHas('food', function ($query) use ($area_id) {
                $query->where('area_id', $area_id);
            });
        }

        // ⚙️ Cargar relaciones específicas del almacén
        if ($warehouse_id) {
            $records = $records->with([
                'warehouses' => function ($query) use ($warehouse_id) {
                    $query->where('warehouse_id', $warehouse_id);
                },
                'item_warehouse_prices' => function ($query) use ($warehouse_id) {
                    $query->where('warehouse_id', $warehouse_id);
                }
            ]);
        }

        return $records->orderBy('description', 'ASC');
    }


    public function getRecordsUltima_Venta($item_id)
    {
        $records = DocumentItem::query()
            ->join('documents', 'documents.id', '=', 'document_items.document_id')
            ->join('persons', 'documents.customer_id', '=', 'persons.id')
            ->where('document_items.item_id', '=', $item_id)
            ->select(
                'documents.date_of_issue',
                'documents.series',
                'documents.number',
                'documents.customer',
                'persons.name as customer_name',
                'persons.number as customer_number',
                'documents.document_type_id',
                'document_items.item_id',
                'document_items.item',
                'document_items.quantity',
                'document_items.unit_value',
                'document_items.total'
            )
            ->orderBy('documents.date_of_issue', 'desc');

        return $records;
    }

    public function getRecordsUltima_Compra(Request $request, $item_id)
    {
        // $date_of_issue = $request->date_of_issue;
        // 
        $records = PurchaseItem::query()
            ->join('purchases', 'purchases.id', '=', 'purchase_items.purchase_id')
            ->join('persons', 'purchases.supplier_id', '=', 'persons.id')
            ->where('purchase_items.item_id', '=', $item_id)
            ->where('persons.type', '=', 'suppliers')
            ->select(
                'purchases.date_of_issue',
                DB::raw("
                CASE 
                    WHEN purchases.document_type_id = 'GU75' THEN purchases.series_guia
                    ELSE purchases.series
                END as series
                "),
                DB::raw("
                    CASE
                        WHEN purchases.document_type_id = 'GU75' THEN purchases.number_guia
                        ELSE purchases.number
                    END  as number
                "),
                'purchases.document_type_id',
                'persons.name as supplier_name',
                'persons.number as supplier_number',
                'purchase_items.purchase_id',
                'purchase_items.item_id',
                'purchase_items.item',
                'purchase_items.quantity',
                'purchase_items.unit_value',
                'purchase_items.total'
            )
            ->orderBy('purchases.date_of_issue', 'desc');

        return $records;
    }
    public function recordsActivity(Request $request)
    {

        $records = RegisterMovement::query();
        $column = $request->column;
        $value = $request->value;

        if ($column && $value) {
            switch ($column) {
                case 'user_id':
                    $records = $records->where('user_id', $value);
                    break;
                case 'date_of_issue':
                    $records = $records->whereDate('created_at', $value);
                    break;
                case 'description':
                    $records = $records->where('description', 'like', "%{$value}%");
                    break;
                case 'event_description':
                    $records = $records->where('event', $value);
                    break;
                case 'model':
                    $model = $this->get_model($value);
                    if ($model) {
                        $records = $records->where('model', $model);
                    }
                    break;
            }
        }

        $records = $records->orderBy('id', 'desc');
        return new RegisterMovementCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function create()
    {
        return view('tenant.items.form');
    }
    public function check_all_stock()
    {
        return view('tenant.items.index_check_stock');
    }
    public function check_stock(Request $request)
    {
        // $items = Item::whereRaw('(SELECT SUM(stock) FROM item_warehouse WHERE item_warehouse.item_id = items.id) != items.stock');
        $items = Item::where(function ($query) {
            $query->whereExists(function ($existsQuery) {
                $existsQuery->select(DB::raw(1))
                    ->from('item_lots')
                    ->whereColumn('item_lots.item_id', 'items.id')
                    ->where('item_lots.has_sale', 0)
                    ->where('item_lots.state', 'Activo');
            })
                ->whereRaw('(SELECT COUNT(*) FROM item_lots WHERE item_lots.item_id = items.id AND item_lots.has_sale = 0 AND item_lots.state = "Activo") != items.stock');



            $query->orWhere(function ($subquery) {
                $subquery->whereRaw('(SELECT SUM(stock) FROM item_warehouse WHERE item_warehouse.item_id = items.id) != items.stock');
            });
        });

        return new ItemStockCollection($items->paginate(config('tenant.items_per_page')));
    }

    public function tables()
    {
        $company = Company::active();
        $item_codes = ItemCodes::all();
        $establishment = Establishment::first();
        $categoria_madera = CategoriaMadera::all();
        $unit_types = UnitType::whereActive()->orderByDescription()->get();
        $currency_types = CurrencyType::whereActive()->orderByDescription()->get();
        $attribute_types = AttributeType::whereActive()->orderByDescription()->get();
        $system_isc_types = SystemIscType::whereActive()->orderByDescription()->get();
        $affectation_igv_types = AffectationIgvType::whereActive()->get();
        $all_commercial_treatments = CommercialTreatment::all()->transform(function ($row, $key) {
            return [
                'id' => null,
                'item_id' => null,
                'commercial_treatment_id' => $row->id,
                'amount' => null,
                'active' => (bool) $row->active,
                'commercial_treatment_description' => $row->description,
            ];
        });
        $areas = Area::all();
        // $warehouse = Warehouse::where('establishment_id', auth()->user()->establishment_id)->first();
        $warehouses = Warehouse::all();
        $accounts = Account::all();
        $payment_method_types = PaymentMethodType::all();
        /* $categories = CategoryItem::all(); */
        $categories = CategoryItem::where('active', 1)->get();
        $brands = Brand::all();
        $configuration = Configuration::first();
        return compact(
            'all_commercial_treatments',
            'categoria_madera',
            'unit_types',
            'payment_method_types',
            'currency_types',
            'attribute_types',
            'system_isc_types',
            'affectation_igv_types',
            'warehouses',
            'accounts',
            'areas',
            'categories',
            'brands',
            'configuration',
            'company',
            'establishment',
            'item_codes',
        );
    }

    public function record($id)
    {
        $record = new ItemResource(Item::findOrFail($id));

        return $record;
    }


    public function store(ItemRequest $request)
    {
        try {
            DB::connection('tenant')->beginTransaction();


            $all_establishment = $request->all_establishment;
            $id = $request->input('id');

            $item = Item::firstOrNew(['id' => $id]);
            $item->item_type_id = '01';
            $item->amount_plastic_bag_taxes = Configuration::firstOrFail()->amount_plastic_bag_taxes;
            $item->fill($request->all());

            $temp_path = $request->input('temp_path');
            $id = $request->input('id');
            $food = Food::firstOrNew(['item_id' => $id]);
            $food->fill($request->all());
            $food->price = $request->sale_unit_price;
            $food->category_food_id = $request->category_id;
            $food->code = $request->internal_id;
            if ($temp_path) {
                $directory = 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'items' . DIRECTORY_SEPARATOR;
                $file_name_old = $request->input('image');
                $file_name_old_array = explode('.', $file_name_old);
                $file_content = file_get_contents($temp_path);
                $datenow = date('YmdHis');
                $file_name = Str::slug($item->description) . '-' . $datenow . '.' . $file_name_old_array[1];
                Storage::put($directory . $file_name, $file_content);
                $item->image = $file_name;
                $food->image = $file_name;
                //--- IMAGE SIZE MEDIUM
                $image = \Image::make($temp_path);
                $file_name = Str::slug($item->description) . '-' . $datenow . '_medium' . '.' . $file_name_old_array[1];
                $image->resize(512, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                Storage::put($directory . $file_name,  (string) $image->encode('jpg', 30));
                $item->image_medium = $file_name;
                //--- IMAGE SIZE SMALL
                $image = \Image::make($temp_path);
                $file_name = Str::slug($item->description) . '-' . $datenow . '_small' . '.' . $file_name_old_array[1];
                $image->resize(256, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                Storage::put($directory . $file_name,  (string) $image->encode('jpg', 20));
                $item->image_small = $file_name;
            } else if (!$request->input('image') && !$request->input('temp_path') && !$request->input('image_url')) {
                $item->image = 'imagen-no-disponible.jpg';
                $food->image = 'imagen-no-disponible.jpg';
            }
            $item->save();
            if ($request->has('item_codes') && is_array($request->item_codes)) {
                // Elimina los códigos anteriores de este item (opcional)
                ItemCodes::where('item_id', $item->id)->delete();
                foreach ($request->item_codes as $code) {
                    if (!empty($code['code_barcode'])) {
                        ItemCodes::create([
                            'item_id' => $item->id,
                            'code_barcode' => $code['code_barcode']
                        ]);
                    }
                }
            }

            $item->item_price_ranges()->delete();
            $item_price_ranges = $request->input('item_price_ranges');
            if ($item_price_ranges) {
                foreach ($item_price_ranges as $item_price_range) {
                    $item->item_price_ranges()->create($item_price_range);
                }
            }
            $commercial_treatments = $request->input('commercial_treatments');
            if ($commercial_treatments && $id == null) {
                foreach ($commercial_treatments as $commercial_treatment) {
                    if ($commercial_treatment['amount'] == null) continue;
                    $item->commercial_treatments()->create($commercial_treatment);
                }
            }
            ItemCategoriaMadera::where('item_id', $item->id)->delete();
            $categoria_madera = $request->input('categoria_madera');
            /*  */
            if (is_array($categoria_madera) && !empty($categoria_madera)) {
                foreach ($categoria_madera as $categoria) { // Usar un nombre diferente para la variable interna
                    if (isset($categoria['precio']) && isset($categoria['id'])) {
                        $newCategoriaMadera = new ItemCategoriaMadera;
                        $newCategoriaMadera->precio = $categoria['precio'];
                        $newCategoriaMadera->categoria_madera_id = $categoria['id'];
                        $newCategoriaMadera->item_id = $item->id;
                        $newCategoriaMadera->save();
                    }
                }
            }

            if ($all_establishment) {
                $warehouses = Warehouse::all()->pluck('id');
                $stock = $item->stock;
                $new_qty = count($warehouses) * $item->stock;
                $id = $item->id;
                foreach ($warehouses as $wh) {
                    $exist = ItemWarehouse::where('warehouse_id', $wh)->where('item_id', $id)->first();

                    if (!isset($exist)) {
                        ItemWarehouse::create([
                            'warehouse_id' => $wh,
                            'stock' => $stock,
                            'item_id' => $item->id,
                            'created_at' => date('Y-m-d H:i:s '),
                            'updated_at' => date('Y-m-d H:i:s '),
                        ]);
                        $inventory = Inventory::create([
                            'type' => 1,
                            'description' => 'Stock Inicial',
                            'item_id' => $item->id,
                            'warehouse_id' => $wh,
                            'quantity' => $stock,
                            'date_of_issue' => date('Y-m-d')
                        ]);

                        Kardex::create([
                            'type' => null,
                            'date_of_issue' => date('Y-m-d'),
                            'item_id' => $item->id,
                            'quantity' => $stock,
                        ]);

                        InventoryKardex::create([
                            'date_of_issue' => date('Y-m-d '),
                            'item_id' => $item->id,
                            'warehouse_id' => $wh,
                            'inventory_kardexable_type' => 'Modules\Inventory\Models\Inventory',
                            'inventory_kardexable_id' => $inventory->id,
                            'quantity' => $stock,
                            'created_at' => date('Y-m-d H:i:s '),
                            'updated_at' => date('Y-m-d H:i:s '),
                            'user_id' => isset(auth()->user()->id) ? auth()->user()->id : null,

                        ]);
                    }
                }
                $item->stock = $new_qty;
                $item->save();
            } else {
                $warehouse_id = $request->warehouse_id;
                if ($item->unit_type_id == 'ZZ' && $warehouse_id) {
                    $item_warehouse = ItemWarehouse::firstOrNew(['item_id' => $item->id, 'warehouse_id' => $warehouse_id]);
                    $item_warehouse->stock = $item->stock;
                    $item_warehouse->save();
                }
            }
            ItemUnitTypePriceRange::whereHas('item_unit_type', function ($query) use ($item) {
                $query->where('item_id', $item->id);
            })->delete();
            ItemUnitType::where('item_id', $item->id)->delete();
            ItemWarehousePrice::where('item_id', $item->id)->delete();
            //---------------------------------------
            if ($request['item_unit_types'] != null) {
                foreach ($request['item_unit_types'] as $unit) {
                    $newUnitType = new ItemUnitType;
                    $newUnitType->fill($unit);
                    $newUnitType->item_id = $item->id;
                    $newUnitType->save();

                    // ItemUnitTypePriceRange::where('unit_type_id', $newUnitType->id)->delete();
                    $item_unit_type_price_ranges = isset($unit['item_unit_type_price_ranges']) ? $unit['item_unit_type_price_ranges'] : [];
                    if ($item_unit_type_price_ranges) {
                        foreach ($item_unit_type_price_ranges as $item_unit_type_price_range) {
                            $newUnitType->item_unit_type_price_ranges()->create($item_unit_type_price_range);
                        }
                    }
                }
            }
            if ($request['color_sizes'] != null) {
                foreach ($request['color_sizes'] as $color_size) {
                    $newColorSize = new ItemColorSize;
                    $newColorSize->fill($color_size);
                    $newColorSize->item_id = $item->id;
                    $newColorSize->warehouse_id = $request['warehouse_id'];
                    $newColorSize->save();
                }
            }
            if ($request['warehouse_prices'] != null) {
                // Limpiamos registros previos
                ItemWarehousePrice::where('item_id', $item->id)->delete();

                $processedWarehouses = [];
                foreach ($request['warehouse_prices'] as $w) {
                    if ($w["price"] != null && !in_array($w["warehouse_id"], $processedWarehouses)) {
                        ItemWarehousePrice::create([
                            'warehouse_id' => $w["warehouse_id"],
                            'item_id' => $item->id,
                            'price' => $w["price"]
                        ]);
                        $processedWarehouses[] = $w["warehouse_id"];
                    }
                }
            }
            if ($request['item_warehouses'] != null) {
                $has_stock = collect($request['item_warehouses'])->some(function ($w) {
                    return $w['stock'] != null && $w['stock'] > 0;
                });

                if ($has_stock) {
                    ItemWarehouse::where('item_id', $item->id)->delete();

                    $processedWarehouses = [];
                    foreach ($request['item_warehouses'] as $w) {
                        if (!in_array($w["warehouse_id"], $processedWarehouses)) {
                            // Asegurar que stock sea 0 si es null
                            $stock = $w["stock"] ?? 0;

                            // Crear registro de almacén
                            $item_warehouse = ItemWarehouse::create([
                                'warehouse_id' => $w["warehouse_id"],
                                'item_id' => $item->id,
                                'stock' => $stock
                            ]);

                            // Solo crear registros relacionados si es nuevo item y tiene stock positivo
                            if (!$id && $stock > 0) {
                                // Crear registro de inventario
                                $inventory = Inventory::create([
                                    'type' => 1,
                                    'description' => 'Stock Inicial',
                                    'item_id' => $item->id,
                                    'warehouse_id' => $w["warehouse_id"],
                                    'quantity' => $stock, // Usar el stock específico del almacén
                                    'date_of_issue' => date('Y-m-d')
                                ]);

                                // Crear registros de kardex solo para este almacén específico
                                Kardex::create([
                                    'type' => null,
                                    'date_of_issue' => date('Y-m-d'),
                                    'item_id' => $item->id,
                                    'quantity' => $stock, // Usar el stock específico del almacén
                                ]);

                                InventoryKardex::create([
                                    'date_of_issue' => date('Y-m-d'),
                                    'item_id' => $item->id,
                                    'warehouse_id' => $w["warehouse_id"],
                                    'inventory_kardexable_type' => 'Modules\Inventory\Models\Inventory',
                                    'inventory_kardexable_id' => $inventory->id,
                                    'quantity' => $stock, // Usar el stock específico del almacén
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                    'user_id' => auth()->id()
                                ]);
                            }

                            $processedWarehouses[] = $w["warehouse_id"];
                        }
                    }
                }
            } else {
                // Si no se especificó ningún almacén, crear registro por defecto en almacén 1
                $exists = ItemWarehouse::where('item_id', $item->id)
                    ->where('warehouse_id', 1)
                    ->exists();

                if (!$exists) {
                    ItemWarehouse::create([
                        'warehouse_id' => 1,
                        'item_id' => $item->id,
                        'stock' => 0
                    ]);
                }
            }
            $lote = null;
            if ($request['lot_code']) {
                $exists = ItemLotsGroup::where('code', $request['lot_code'])
                    ->where('warehouse_id', $request['warehouse_id'])
                    ->where('item_id', $item->id)
                    ->first();
                if (!$exists) {
                    $item_group = new ItemLotsGroup;
                    $item_group->warehouse_id = $request['warehouse_id'];
                    $item_group->item_id = $item->id;
                    $item_group->date_of_due = $request['date_of_due'];
                    $item_group->code = $request['lot_code'];
                    $item_group->quantity = $request['stock'];
                    $item_group->save();
                    $lote = $item_group->id;
                }
            }
            $v_lots = isset($request->lots) ? $request->lots : [];

            foreach ($v_lots as $lot) {
                $series = $lot['series'];
                $item_id = $item->id;
                $exists = ItemLot::where('series', $series)->where('item_id', $item_id)
                    ->where('warehouse_id', $request['warehouse_id'])
                    ->first();
                if (!$exists) {
                    $item->lots()->create([
                        'date' => $lot['date'],
                        'series' => $lot['series'],
                        'item_id' => $item->id,
                        'warehouse_id' => $request['warehouse_id'],
                        'has_sale' => false,
                        'lote_id' => $lote,
                        'state' => $lot['state'],
                    ]);
                }
            }


            $item_id =  $item->id;
            if ($item_id != 0) {
                $food->item_id = $item_id;
            }
            $food->save();
            //---------------------------------------
            if (!$id) {
                $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
                $warehouse = Warehouse::where('establishment_id', $establishment->id)->first();
            } else {
                // $item->lots()>delete();
                $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
                $warehouse = Warehouse::where('establishment_id', $establishment->id)->first();
                $v_lots = isset($request->lots) ? $request->lots : [];
            }


            $item->update();
            DB::connection('tenant')->commit();
            return [
                'success' => true,
                'message' => ($id) ? 'Producto editado con éxito' : 'Producto registrado con éxito',
                'id' => $item->id,
                'data' => $item
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::connection('tenant')->rollBack();
            return [
                'success' => false,
                'message' => 'Error inesperado, no se pudo registrar el producto'
            ];
        }
    }

    public function storeBonusUnitType(Request $request)
    {

        $bonus_unit_type = $request->item_unit_type;
        BonusUnitType::query()->delete();
        foreach ($bonus_unit_type as $unit) {
            $newUnitType = new BonusUnitType;
            $newUnitType->fill($unit);
            $newUnitType->save();

            ItemUnitType::where('description', $unit['description'])->update(['qty_min' => $unit['qty_min'], 'qty_free' => $unit['qty_free']]);
        }

        return [
            'success' => true,
            'message' => 'Registro exitoso'
        ];
    }
    public function bonusUnitType()
    {
        $bonus_unit_type = BonusUnitType::all();
        $item_unit_type = ItemUnitType::all()->pluck('description')->unique()->values();


        return [
            'success' => true,
            'bonus_unit_type' => $bonus_unit_type,
            'item_unit_type' => $item_unit_type
        ];
    }
    /* public function destroy($id)
    {
        try {
            $item = Item::findOrFail($id);

            // Verificar si el item tiene registros en inventories
            $has_inventory = Inventory::where('item_id', $id)->exists();

            if ($has_inventory) {
                return [
                    'success' => false,
                    'message' => 'No se puede eliminar el producto porque ya tiene stock cargado en inventario'
                ];
            }

            ItemUnitType::where('item_id', $id)->delete();
            ItemLotsGroup::where('item_id', $id)->delete();
            if ($item) {
                Food::where('item_id', $id)->delete();
            }
            $this->deleteRecordInitialKardex($item);
            $item->delete();

            return [
                'success' => true,
                'message' => 'Producto eliminado con éxito'
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ($e->getCode() == '23000') ?
                ['success' => false, 'message' => 'El producto esta siendo usado por otros registros, no puede eliminar'] :
                ['success' => false, 'message' => 'Error inesperado, no se pudo eliminar el producto'];
        }
    } */

    public function destroy($id)
    {
        try {
            $item = Item::findOrFail($id);

            // Verificar los movimientos de inventario
            $inventory_movements = Inventory::where('item_id', $id)->get();

            if ($inventory_movements->count() > 1) {
                return [
                    'success' => false,
                    'message' => 'No se puede eliminar el producto porque ya tiene movimientos en inventario'
                ];
            }

            // Si hay solo un movimiento, validar que sea 0
            if ($inventory_movements->count() === 1) {
                $inv = $inventory_movements->first();

                // Puedes ajustar aquí si usas campo tipo (ej. 'initial')
                if ($inv->quantity != 0) {
                    return [
                        'success' => false,
                        'message' => 'No se puede eliminar el producto porque ya tiene stock cargado en inventario'
                    ];
                }

                // En este caso, sí podemos eliminar el único movimiento inicial
                $inv->delete();
            }

            // Eliminar asociaciones
            ItemUnitType::where('item_id', $id)->delete();
            ItemLotsGroup::where('item_id', $id)->delete();

            if ($item) {
                Food::where('item_id', $id)->delete();
            }

            $this->deleteRecordInitialKardex($item);
            $item->delete();

            return [
                'success' => true,
                'message' => 'Producto eliminado con éxito'
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ($e->getCode() == '23000') ?
                ['success' => false, 'message' => 'El producto está siendo usado por otros registros, no puede eliminar'] :
                ['success' => false, 'message' => 'Error inesperado, no se pudo eliminar el producto'];
        }
    }
    
    public function exportBarCode(Request $request)
    {
        ini_set("pcre.backtrack_limit", "50000000");

        $start = $request[0];
        $end = $request[1];

        $records = Item::whereBetween('id', [$start, $end]);
        $extradata = [];
        // $isPharmacy = false;
        // if ($request->has('isPharmacy')) {
        //     $isPharmacy = ($request->isPharmacy === 'true') ? true : false;
        // }
        // if ($isPharmacy == true) {
        //     $extradata[] = 'sanitary';
        //     $extradata[] = 'cod_digemid';
        //     $records->Pharmacy();
        // }
        $extra_data = $extradata;
        $records = $records->get();
        $pdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => [
                104.1,
                101.6
            ],
            'margin_top' => 2,
            'margin_right' => 2,
            'margin_bottom' => 0,
            'margin_left' => 2
        ]);
        $html = view('tenant.items.exports.items-barcode', compact('records', 'extra_data'))->render();

        $pdf->WriteHTML($html, HTMLParserMode::HTML_BODY);

        $pdf->output('etiquetas_' . now()->format('Y_m_d') . '.pdf', 'I');
    }


    public function printBarCode(Request $request)
    {
        ini_set("pcre.backtrack_limit", "50000000");
        $id = $request->id;

        $record = Item::find($id);
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
        $warehouse = Warehouse::where('establishment_id', $establishment->id)->first();
        $item_warehouse = ItemWarehouse::where([['item_id', $id], ['warehouse_id', $warehouse->id]])->first();
        $company = Company::first();
        if (!$item_warehouse) {
            return [
                'success' => false,
                'message' => "El producto seleccionado no esta disponible en su almacen!"
            ];
        }

        if ($item_warehouse->stock < 1) {
            return [
                'success' => false,
                'message' => "El producto seleccionado no tiene stock disponible en su almacen, no puede generar etiquetas!"
            ];
        }

        $stock = $item_warehouse->stock;

        $pdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => [
                109,
                25
            ],
            'margin_top' => 5,
            'margin_right' => 0,
            'margin_bottom' => 0,
            'margin_left' => 0
        ]);
        $acumular = 0;
        $html = view('tenant.items.exports.items-barcode-id', compact('record', 'stock', 'company', 'acumular'))->render();

        $pdf->WriteHTML($html, HTMLParserMode::HTML_BODY);

        $pdf->output('etiquetas_' . now()->format('Y_m_d') . '.pdf', 'I');
    }

    public function destroyItemUnitType($id)
    {
        $item_unit_type = ItemUnitType::findOrFail($id);
        $item_unit_type->delete();

        return [
            'success' => true,
            'message' => 'Registro eliminado con éxito'
        ];
    }


    public function import_prices_range_unit_type(Request $request)
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 30000);
        if ($request->hasFile('file')) {
            try {
                $import = new ItemsPriceRangeUnitTypeImport();
                $import->import($request->file('file'), null, Excel::XLSX);
                $data = $import->getData();
                return [
                    'success' => true,
                    'message' =>  __('app.actions.upload.success'),
                    'data' => $data
                ];
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' =>  $e->getMessage()
                ];
            }
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }
    public function import_prices_range(Request $request)
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 30000);
        if ($request->hasFile('file')) {
            try {
                $import = new ItemsPriceRangeImport();
                $import->import($request->file('file'), null, Excel::XLSX);
                $data = $import->getData();
                return [
                    'success' => true,
                    'message' =>  __('app.actions.upload.success'),
                    'data' => $data
                ];
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' =>  $e->getMessage()
                ];
            }
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }
    public function import_prices(Request $request)
    {

        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 30000);
        if ($request->hasFile('file')) {
            try {
                $import = new ItemsPriceImport();
                $import->import($request->file('file'), null, Excel::XLSX);
                $data = $import->getData();
                return [
                    'success' => true,
                    'message' =>  __('app.actions.upload.success'),
                    'data' => $data
                ];
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' =>  $e->getMessage()
                ];
            }
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }
    public function excelForImport(Request $request)
    {
        $records = $this->getRecords($request, true)->get();
        $company = Company::first();
        $warehouse_id = $request->warehouse_id;
        $establishment = $request->establishment_id
            ? Establishment::findOrFail($request->establishment_id)
            : auth()->user()->establishment;

        foreach ($records as $key => $row) {
            // Verificar stock en base al almacén
            if ($warehouse_id) {
                $item_warehouse = ItemWarehouse::where([['item_id', $row->id], ['warehouse_id', $warehouse_id]])->first();
                $row->stock = $item_warehouse ? $item_warehouse->stock : 0;

                // Obtener el precio para el almacén específico usando la relación warehousePrices
                $warehouse_price = $row->warehousePrices
                    ? $row->warehousePrices->firstWhere('warehouse_id', $warehouse_id)
                    : null;

                // Usar el precio del almacén si existe, sino el sale_unit_price
                $row->price = $warehouse_price
                    ? number_format($warehouse_price->price, 2, ".", "")
                    : number_format($row->sale_unit_price, 2, ".", "");
            } else {
                // Sumar el stock de todos los almacenes si no se seleccionó uno específico
                $row->stock = ItemWarehouse::where('item_id', $row->id)->sum('stock');
                $row->price = number_format($row->sale_unit_price, 2, ".", "");
            }
        }

        $warehouse = Warehouse::find($warehouse_id);
        $description_warehouse = $warehouse ? $warehouse->description : 'Todos';
        $description_warehouse = str_replace(['-', ' '], ['_', '_'], $description_warehouse);

        return (new ItemExportGeneralForImport)
            ->records($records)
            ->company($company)
            ->warehouse_id($warehouse_id)
            ->establishment($establishment)
            ->download('Productos_de_' . $description_warehouse . '_' . Carbon::now() . '.xlsx');
    }
    public function excel(Request $request)
    {
        $records = $this->getRecords($request, true)

            ->get();
        $company = Company::first();
        $warehouse_id = $request->warehouse_id;
        $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;
        foreach ($records as $key => $row) {
            if ($warehouse_id) {
                $item_warehouse = ItemWarehouse::where([['item_id', $row->id], ['warehouse_id', $warehouse_id]])->first();
                $row->stock = ($item_warehouse) ? $item_warehouse->stock : 0;
            } else {
                $item_sum_stock = ItemWarehouse::where('item_id', $row->id)->sum('stock');
                $row->stock = $item_sum_stock;
            }
        }
        return (new ItemExportGeneral)
            ->records($records)
            ->company($company)
            ->establishment($establishment)
            ->download('Reporte_Productos_' . Carbon::now() . '.xlsx');
    }
    public function import(Request $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '2048M');
        if ($request->hasFile('file')) {
            try {
                $import = new ItemsImport();
                $import->import($request->file('file'), null, Excel::XLSX);
                $data = $import->getData();
                $errors = $import->getErrors();
                return [
                    'success' => true,
                    'message' =>  __('app.actions.upload.success'),
                    'data' => $data,
                    'errors' => $errors
                ];
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' =>  $e->getMessage()
                ];
            }
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $new_request = [
                'file' => $request->file('file'),
                'type' => $request->input('type'),
            ];

            return $this->upload_image($new_request);
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }

    function upload_image($request)
    {
        $file = $request['file'];
        $type = $request['type'];

        $temp = tempnam(sys_get_temp_dir(), $type);
        file_put_contents($temp, file_get_contents($file));

        $mime = mime_content_type($temp);
        $data = file_get_contents($temp);

        return [
            'success' => true,
            'data' => [
                'filename' => $file->getClientOriginalName(),
                'temp_path' => $temp,
                'temp_image' => 'data:' . $mime . ';base64,' . base64_encode($data)
            ]
        ];
    }

    private function deleteRecordInitialKardex($item)
    {

        if ($item->kardex->count() == 1) {
            ($item->kardex[0]->type == null) ? $item->kardex[0]->delete() : false;
        }
    }


    public function visibleStore(Request $request)
    {
        $item = Item::find($request->id);

        if (!$item->internal_id && $request->apply_store) {
            return [
                'success' => false,
                'message' => 'Para habilitar la visibilidad, debe asignar un codigo interno al producto',
            ];
        }

        $visible = $request->apply_store == true ? 1 : 0;
        $item->apply_store = $visible;
        $item->save();

        return [
            'success' => true,
            'message' => ($visible > 0) ? 'El Producto ya es visible en tienda virtual' : 'El Producto ya no es visible en tienda virtual',
            'id' => $request->id
        ];
    }

    public function duplicate(Request $request)
    {
        // return $request->id;
        $obj = Item::find($request->id);
        $new = $obj->replicate();
        $new->save();

        return [
            'success' => true,
            'data' => [
                'id' => $new->id,
            ],
        ];
    }

    public function disableItem($id, $warehouse_id = null)
    {
        try {
            // Contar cuántos almacenes están asociados al producto
            $warehouseCount = DB::Connection('tenant')->table('item_warehouse')
                ->where('item_id', $id)
                ->count();

            // Si hay solo un almacén asociado y no se pasó warehouse_id, utilizar ese almacén por defecto
            if ($warehouseCount === 1 && $warehouse_id === null) {
                // Obtener el warehouse_id del único almacén
                $warehouse_id = DB::Connection('tenant')->table('item_warehouse')
                    ->where('item_id', $id)
                    ->value('warehouse_id');
            }

            // Verificar si el producto está asociado con más de un almacén
            if ($warehouseCount === 1) {
                // Si hay un solo almacén, proceder a inhabilitarlo
                $updated = DB::Connection('tenant')->table('item_warehouse')
                    ->where('item_id', $id)
                    ->where('warehouse_id', $warehouse_id)
                    ->update(['active' => false]);

                if ($updated) {
                    return response()->json([
                        'success' => true,
                        'message' => 'El producto ha sido inhabilitado en el almacén único.'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se pudo inhabilitar el producto en el almacén único.'
                    ], 400);
                }
            } else if ($warehouseCount > 1) {
                // Si hay más de un almacén, realizar la actualización en el almacén seleccionado
                $updated = DB::Connection('tenant')->table('item_warehouse')
                    ->where('item_id', $id)
                    ->where('warehouse_id', $warehouse_id)
                    ->update(['active' => false]);

                if ($updated) {
                    return response()->json([
                        'success' => true,
                        'message' => 'El producto ha sido inhabilitado en el almacén seleccionado.'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se pudo inhabilitar el producto en el almacén seleccionado.'
                    ], 400);
                }
            }

            // Si no se encontró ningún almacén, devolver un error
            return response()->json([
                'success' => false,
                'message' => 'No se encontraron almacenes asociados al producto.'
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error inesperado, no se pudo inhabilitar el producto.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function enableItem($id, $warehouse_id = null)
    {
        try {
            // Contar cuántos almacenes están asociados al producto
            $warehouseCount = DB::Connection('tenant')->table('item_warehouse')
                ->where('item_id', $id)
                ->count();

            // Si solo hay un almacén, asignar ese almacén automáticamente
            if ($warehouseCount === 1 && $warehouse_id === null) {
                $warehouse_id = DB::Connection('tenant')->table('item_warehouse')
                    ->where('item_id', $id)
                    ->value('warehouse_id');
            }

            // Si hay almacenes asociados, proceder con la actualización
            if ($warehouseCount > 0) {
                // Actualizar el producto a habilitado en el almacén seleccionado
                $updated = DB::Connection('tenant')->table('item_warehouse')
                    ->where('item_id', $id)
                    ->where('warehouse_id', $warehouse_id)
                    ->update(['active' => true]);

                // Verificar si la actualización fue exitosa
                if ($updated) {
                    return response()->json([
                        'success' => true,
                        'message' => 'El producto ha sido habilitado en el almacén seleccionado.'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se pudo habilitar el producto en el almacén seleccionado.'
                    ], 400);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron almacenes asociados al producto.'
                ], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error inesperado, no se pudo habilitar el producto.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function images($item)
    {
        $records = ItemImage::where('item_id', $item)->get()->transform(function ($row) {
            return [
                'id' => $row->id,
                'item_id' => $row->item_id,
                'image' => $row->image,
                'id' => $row->id,
                'name' => $row->image,
                'url' => asset('storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'items' . DIRECTORY_SEPARATOR . $row->image)
            ];
        });
        return [
            'success' => true,
            'data' => $records
        ];
    }

    public function delete_images($id)
    {
        $record = ItemImage::findOrFail($id);
        $record->delete();

        return [
            'success' => true,
            'message' => 'Imagen eliminada con éxito'
        ];
    }

    public function disable($id)
    {
        try {

            $item = Item::findOrFail($id);
            $item->active = 0;
            $item->save();

            return [
                'success' => true,
                'message' => 'Producto inhabilitado con éxito'
            ];
        } catch (Exception $e) {

            return  ['success' => false, 'message' => 'Error inesperado, no se pudo inhabilitar el producto'];
        }
    }

    public function enable($id)
    {
        try {

            $item = Item::findOrFail($id);
            $item->active = 1;
            $item->save();

            return [
                'success' => true,
                'message' => 'Producto habilitado con éxito'
            ];
        } catch (Exception $e) {

            return  ['success' => false, 'message' => 'Error inesperado, no se pudo habilitar el producto'];
        }
    }
    public function disguise($id)
    {
        try {

            $item = Item::findOrFail($id);
            $item->active = 0;
            $item->save();

            return [
                'success' => true,
                'message' => 'Producto anulado con éxito'
            ];
        } catch (Exception $e) {

            return  ['success' => false, 'message' => 'Error inesperado, no se pudo anular el producto'];
        }
    }
}
