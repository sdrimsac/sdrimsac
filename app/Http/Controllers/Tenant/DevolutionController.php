<?php

namespace App\Http\Controllers\Tenant;

use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Exports\ProductosExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\ProductosCollection;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Company;
use App\Models\Tenant\Document;
use App\Models\Tenant\DocumentItem;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Inventory;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\Warehouse;
use Modules\Restaurant\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Inventory\Models\Category;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PgSql\Lob;

class DevolutionController extends Controller
{

    public function columns()
    {
        return [
            'item_id' => 'Producto'
        ];
    }

    public function tables()
    {
        return response()->json([
            'establishment' => Establishment::whereNotNull('printer')->get(),
            'areas' => Area::whereNotNull('printer')->get(),
            'items' => Item::whereNotNull('description')->get(),
            'warehouses' => Warehouse::all(),
            'categories' => Category::all(),
            'inventories' => Inventory::whereNotNull('created_at')->get(),
            'configuration' => Configuration::first(),
        ]);
    }

    public function tables1()
    {
        $printers = Area::whereNotNull('printer')->get()
            ->transform(function ($row, $key) {
                return [
                    'id' => $row->id,
                    'description' => $row->description,
                    'printer' => $row->printer,
                ];
            });

        return [
            'printers' => $printers,
            //'items' => $this->optionsItemWareHouse(),
            'warehouses' => $this->optionsWarehouse()
        ];
    }

    public function searchDevolutions(Request $request)
    {
        $series = $request->input('series');
        $number = $request->input('number');

        if (!$series || !$number) {
            return response()->json([
                'success' => false,
                'message' => 'Serie y número del documento son requeridos'
            ], 400);
        }

        try {
            $document = Document::where('series', $series)
                ->where('number', $number)
                ->with(['person', 'document_type', 'currency_type'])
                ->first();

            if (!$document) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró el documento con la serie y número especificados'
                ], 404);
            }

            $documentItems = DocumentItem::where('document_id', $document->id)
                ->with(['m_item:id,description,internal_id,unit_type_id'])
                ->get()
                ->map(function ($documentItem) {
                    return [
                        'id' => $documentItem->m_item->id ?? null,
                        'description' => $documentItem->m_item->description ?? 'N/A',
                        'internal_id' => $documentItem->m_item->internal_id ?? 'N/A',
                        'quantity' => $documentItem->quantity,
                        'unit_price' => $documentItem->unit_price,
                        'total' => $documentItem->total,
                        'unit_value' => $documentItem->unit_value ?? 0,
                        'affectation_igv_type_id' => $documentItem->affectation_igv_type_id,
                        'system_isc_type_id' => $documentItem->system_isc_type_id,
                        'price_type_id' => $documentItem->price_type_id,
                        'color_size' => $documentItem->color_size,
                        'lotes' => $documentItem->lotes,
                        'lots' => $documentItem->lots,
                    ];
                });

            return response()->json([
                'success' => true,
                'document' => [
                    'id' => $document->id,
                    'series' => $document->series,
                    'number' => $document->number,
                    'date_of_issue' => $document->date_of_issue,
                    'customer_name' => $document->customer_name ?? 'N/A',
                    'customer_number' => $document->customer_number ?? 'N/A',
                    'total' => $document->total,
                    'document_type' => $document->document_type->description ?? 'N/A'
                ],
                'items' => $documentItems
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar el documento: ' . $e->getMessage()
            ], 500);
        }
    }

    public function get_records(Request $request)
    {
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $qty_type = $request->qty_type;
        /* $item_description = $request->item_description; */
        $records = Inventory::whereNotNull('inventory_transaction_id')
            ->whereHas('inventoryTransaction', function ($query) use ($qty_type) {
                if ($qty_type) {
                    $query->where('type', $qty_type);
                } else {
                    $query->whereIn('type', ['input', 'output']);
                }
            })

            ->select(['id', 'inventory_transaction_id', 'quantity', 'item_id', 'warehouse_id', 'created_at', 'lot_code', 'lots', 'color_size'])
            ->with([
                'inventoryTransaction:id,type',
                'item:id,description,internal_id,category_id',
                'item.category:id,name',
                'warehouse:id,description'
            ]);

        /* $records->whereHas('inventoryTransaction', function ($query) {
            $query->whereIn('type', ['input', 'output']);
        }); */

        $records = $records->orderBy('updated_at', 'desc');

        if ($date_start || $date_end) {
            if ($date_start && $date_end) {
                $records = $records->whereBetween('created_at', [$date_start, $date_end]);
            } else {
                $records = $records->where('created_at', $date_start ?? $date_end);
            }
        }
        return $records;
    }

    public function records(Request $request)
    {

        $records = $this->get_records($request);

        return new ProductosCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function store(Request $request)
    {
        $result = DB::connection('tenant')->transaction(function () use ($request) {
            $item_id = $request->input('item_id');
            $warehouse_id = $request->input('warehouse_id');
            $quantity = $request->input('quantity');

            $item_warehouse = ItemWarehouse::firstOrNew([
                'item_id' => $item_id,
                'warehouse_id' => $warehouse_id
            ]);
            if ($item_warehouse->id) {
                return [
                    'success' => false,
                    'message' => 'El producto ya se encuentra registrado en el almacén indicado.'
                ];
            }

            // $item_warehouse->stock = $quantity;
            // $item_warehouse->save();

            $inventory = new Inventory();
            $inventory->type = 1;
            $inventory->description = 'Stock inicial';
            $inventory->item_id = $item_id;
            $inventory->warehouse_id = $warehouse_id;
            $inventory->quantity = $quantity;
            $inventory->save();

            return  [
                'success' => true,
                'message' => 'Producto registrado en almacén'
            ];
        });

        return $result;
    }

    public function move(Request $request)
    {
        $result = DB::connection('tenant')->transaction(function () use ($request) {
            $id = $request->input('id');
            $item_id = $request->input('item_id');
            $warehouse_id = $request->input('warehouse_id');
            $warehouse_new_id = $request->input('warehouse_new_id');
            $quantity = $request->input('quantity');
            $quantity_move = $request->input('quantity_move');

            if ($warehouse_id === $warehouse_new_id) {
                return  [
                    'success' => false,
                    'message' => 'El almacén destino no puede ser igual al de origen'
                ];
            }
            if ($quantity < $quantity_move) {
                return  [
                    'success' => false,
                    'message' => 'La cantidad a trasladar no puede ser mayor al que se tiene en el almacén.'
                ];
            }

            //Transaction
            // $item_warehouse_new = ItemWarehouse::firstOrNew(['item_id' => $item_id,
            //                                                  'warehouse_id' => $warehouse_new_id]);

            // $stock_new = ($item_warehouse_new)?$item_warehouse_new->stock + $quantity_move:$quantity_move;
            // $item_warehouse_new->stock = $stock_new;
            // $item_warehouse_new->save();

            // $item_warehouse = ItemWarehouse::find($id);
            // $item_warehouse->stock = (float) $quantity - (float)$quantity_move;
            // $item_warehouse->save();

            $inventory = new Inventory();
            $inventory->type = 2;
            $inventory->description = 'Traslado';
            $inventory->item_id = $item_id;
            $inventory->warehouse_id = $warehouse_id;
            $inventory->warehouse_destination_id = $warehouse_new_id;
            $inventory->quantity = $quantity_move;
            $inventory->save();

            return  [
                'success' => true,
                'message' => 'Producto trasladado con éxito'
            ];
        });

        return $result;
    }

    public function remove(Request $request)
    {
        $result = DB::connection('tenant')->transaction(function () use ($request) {
            $item_id = $request->input('item_id');
            $warehouse_id = $request->input('warehouse_id');
            $quantity = $request->input('quantity');
            $quantity_remove = $request->input('quantity_remove');

            //Transaction
            $item_warehouse = ItemWarehouse::where('item_id', $item_id)
                ->where('warehouse_id', $warehouse_id)
                ->first();
            if (!$item_warehouse) {
                return [
                    'success' => false,
                    'message' => 'El producto no se encuentra en el almacén indicado'
                ];
            }

            if ($quantity < $quantity_remove) {
                return  [
                    'success' => false,
                    'message' => 'La cantidad a retirar no puede ser mayor al que se tiene en el almacén.'
                ];
            }

            // $item_warehouse->stock = $quantity - $quantity_remove;
            // $item_warehouse->save();

            $inventory = new Inventory();
            $inventory->type = 3;
            $inventory->description = 'Retirar';
            $inventory->item_id = $item_id;
            $inventory->warehouse_id = $warehouse_id;
            $inventory->quantity = $quantity_remove;
            $inventory->save();

            return  [
                'success' => true,
                'message' => 'Producto trasladado con éxito'
            ];
        });

        return $result;
    }

    public function excel(Request $request)
    {
        $company = Company::first();
        $establishment = Establishment::first();
        $category_id = $request->category_id;
        $reports = $this->get_records($request)->get();

        return Excel::download((new ProductosExport())
                ->records($reports)
                ->establishment($establishment)
                ->company($company),
            'ReporteTransac_' . Carbon::now()->format('Ymd_His') . '.xlsx'
        );
    }

    public function recordPdf($type, Request $request)
    {
        $transfer = Inventory::with(['item'])->find($type);
        $company = Company::first();
        $warehouse_id = $transfer->warehouse_id;
        $establishment_id = Warehouse::find($warehouse_id)->establishment_id; 
        $establishment = Establishment::find($establishment_id);
        $printer = $establishment->printer;

        Storage::makeDirectory('public/pdfs');

        // Generate unique filenames based on inventory ID
        $filename80 = 'pdfs/pdf_80mm_' . $type . '.pdf';
        $filenameA4 = 'pdfs/pdf_a4_' . $type . '.pdf';

        // Calcular altura dinámica según cantidad de tallas/colores
        $base_height = 8 * 30; // altura base
        $extra_height = 0;
        $color_size = is_string($transfer->color_size) ? json_decode($transfer->color_size, true) : $transfer->color_size;
        if (!empty($color_size) && is_array($color_size)) {
            $extra_height = count($color_size) * 30; // 30px por cada talla/color
        }
        $height = $base_height + $extra_height + 50; // 50px extra para cabecera y márgenes

        // Check if files don't exist before generating
        if (!Storage::disk('public')->exists($filename80)) {
            PDF::loadView('tenant.productos.guides_salida', [
                'transfer' => $transfer,
                'company' => $company,
                'establishment' => $establishment
            ])
            ->setPaper(array(0, 0, 249.45, $height)) // Set 80mm width (249.45 points = 80mm)
            ->save(storage_path('app/public/' . $filename80));
        }

        if (!Storage::disk('public')->exists($filenameA4)) {
            PDF::loadView('tenant.productos.guides_salida_a4', [
                'transfer' => $transfer,
                'company' => $company,
                'establishment' => $establishment
            ])->save(storage_path('app/public/' . $filenameA4));
        }

        return response()->json([
            'pdf_80mm_url' => asset('storage/' . $filename80),
            'pdf_a4_url' => asset('storage/' . $filenameA4),
            'printer' => $printer,
            'success' => true
        ]);
    }


    public function printTransfer($type)
    {
        $transfer = Inventory::with(['item'])->find($type);

        Log::info("Imprimiendo traslado de inventario ID: " . $transfer->id);

        $company = Company::first();
        $warehouse_id = $transfer->warehouse_id;
        $establishment_id = Warehouse::find($warehouse_id)->establishment_id;
        $establishment = Establishment::find($establishment_id);

        $pdf = Pdf::loadView('tenant.productos.guides_salida', [
            'transfer' => $transfer,
            'company' => $company,
            'establishment' => $establishment
        ]);

        return $pdf->stream('guides_salida.pdf');
    }

}
