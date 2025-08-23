<?php

namespace Modules\Inventory\Http\Controllers;

use Exception;
//use App\Models\Tenant\Item;
use App\Models\Tenant\Item;
use Illuminate\Http\Request;
use App\Models\Tenant\Document;
use App\Models\Tenant\Purchase;
use App\Models\Tenant\SaleNote;
use Modules\Item\Models\ItemLot;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Tenant\InventoryKardex;
use Modules\Item\Models\ItemLotsGroup;
use Modules\Inventory\Models\Inventory;
use Modules\Inventory\Models\Warehouse;
use Modules\Inventory\Models\ItemWarehouse;
use Modules\Inventory\Traits\InventoryTrait;
use Modules\Inventory\Models\InventoryTransaction;
use Modules\Inventory\Http\Requests\InventoryRequest;
use Modules\Inventory\Http\Resources\InventoryResource;
use Modules\Inventory\Http\Resources\InventoryCollection;
use App\Http\Controllers\Tenant\WhatsappController;
use App\Imports\ItemColorSizeImport;
use App\Models\Tenant\ItemColorSize;
use App\Models\Tenant\NumberActivity;
use App\Models\Tenant\SaleNoteItem;
use App\Services\ItemCodeService;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Number;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    use InventoryTrait;

    public function index()
    {
        return view('inventory::inventory.index');
    }
    public function updateinventory()
    {
        return view('inventory::inventory.upddate_inventory');
    }
    public function updatestore(Request $request)
    {
        //
        try {
            DB::connection('tenant')->table('inventories')->update(['date_of_issue' => $request->date_of_issue]);
            $documents = InventoryKardex::where('inventory_kardexable_type', "App\Models\Tenant\Document")->get();
            $purchases = InventoryKardex::where('inventory_kardexable_type', "App\Models\Tenant\Purchase")->get();
            $saleNotes = InventoryKardex::where('inventory_kardexable_type', "App\Models\Tenant\SaleNote")->get();

            DB::connection('tenant')->table('inventory_kardex')
                ->where('inventory_kardexable_type', "Modules\Inventory\Models\Inventory")
                ->update(['date_of_issue' => $request->date_of_issue]);
            foreach ($purchases as $key => $row_purchases) {
                $purchase = Purchase::where('id', $row_purchases->inventory_kardexable_id)->first();
                if ($purchase != null) {
                    $purchase_save = InventoryKardex::findOrFail($row_purchases->id);
                    $purchase_save->date_of_issue = $purchase->date_of_issue;
                    $purchase_save->save();
                } else {
                    $data = InventoryKardex::findOrFail($row_purchases->id);
                    $data->delete();
                }
            }
            foreach ($documents as $key => $row_documents) {
                $document = Document::where('id', $row_documents->inventory_kardexable_id)->first();
                if ($document != null) {
                    $Document_save = InventoryKardex::findOrFail($row_documents->id);
                    $Document_save->date_of_issue = $document->date_of_issue;
                    $Document_save->save();
                } else {
                    $data = InventoryKardex::findOrFail($row_documents->id);
                    $data->delete();
                }
            }
            foreach ($saleNotes as $key => $row_saleNote) {
                $saleNote = SaleNote::where('id', $row_saleNote->inventory_kardexable_id)->first();
                if ($saleNote != null) {
                    $Document_save = InventoryKardex::findOrFail($row_saleNote->id);
                    $Document_save->date_of_issue = $document->date_of_issue;
                    $Document_save->save();
                } else {
                    $data = InventoryKardex::findOrFail($row_saleNote->id);
                    $data->delete();
                }
            }
        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }


        return [
            "success" => true,
            "message" => "Se actualizo el inventario de Producto"
        ];
    }
    public function resetKardex()
    {
        SaleNoteItem::whereNotNull('inventory_kardex_id')->update(['inventory_kardex_id' => null]);
        InventoryKardex::query()->delete();
        ItemWarehouse::chunk(500, function ($itemWarehouses) {
            DB::transaction(function () use ($itemWarehouses) {
                $inventoryData = [];
                foreach ($itemWarehouses as $itemWarehouse) {
                    $inventoryData[] = [
                        'type' => 1,
                        'description' => 'Stock inicial',
                        'item_id' => $itemWarehouse->item_id,
                        'warehouse_id' => $itemWarehouse->warehouse_id,
                        'quantity' => max($itemWarehouse->stock, 0), // Asegurar que el stock sea al menos 0
                    ];
                    $itemWarehouse->stock = 0;
                    $itemWarehouse->save();
                }

                foreach ($inventoryData as $data) {
                    Inventory::create($data);
                }
            });
        });
        return [
            "success" => true,
            "message" => "Se reseteo el inventario de Producto"
        ];
    }
    public function columns()
    {
        return [
            'description' => 'Producto',
            'internal_id' => 'Código interno',
            'warehouse' => 'Almacén',
        ];
    }

    public function records(Request $request)
    {

        $column = $request->input('column');

        if ($column == 'warehouse') {

            $records = ItemWarehouse::with(['item', 'warehouse'])
                ->whereHas('item', function ($query) use ($request) {
                    $query->where('unit_type_id', '!=', 'ZZ');
                    $query->whereNotIsSet();
                })
                ->whereHas('warehouse', function ($query) use ($request) {
                    $query->where('description', 'like', '%' . $request->value . '%');
                })
                ->orderBy('item.description');
        } else {

            $records = ItemWarehouse::with(['item', 'warehouse'])
                ->whereHas('item', function ($query) use ($request) {
                    $query->where('unit_type_id', '!=', 'ZZ');
                    $query->whereNotIsSet();
                    $query->where($request->column, 'like', '%' . $request->value . '%');
                })->orderBy('item.description');
        }

        return new InventoryCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function tables()
    {
        return [
            'items' => $this->optionsItem(),
            'warehouses' => $this->optionsWarehouse()
        ];
    }

    public function record($id)
    {
        $record = new InventoryResource(ItemWarehouse::with(['item', 'warehouse'])->findOrFail($id));

        return $record;
    }

    public function getItems(Request $request)
    {
        $value = $request->value;
        $records = Item::with(['warehouses', 'itemwarehouses.warehouse'])
            ->where([['item_type_id', '01'], ['unit_type_id', '!=', 'ZZ']])
            ->whereNotIsSet()
            ->where(function ($query) use ($value) {
                $query->where('description', 'like', '%' . $value . '%')
                    ->orWhere('internal_id', 'like', '%' . $value . '%')
                    ->orWhere('barcode', 'like', '%' . $value . '%');
            })
            ->take(25)
            ->get();

        return collect($records)->transform(function ($row) {
            return  [
                'id' => $row->id,
                'description' => ($row->internal_id) ? "{$row->internal_id} - {$row->description}" : $row->description,
                'lots_enabled' => (bool) $row->lots_enabled,
                'series_enabled' => (bool) $row->series_enabled,
                'has_color_size' => (bool) $row->has_color_size,
                'color_size' => collect($row->color_size),
                'warehouse' => $row->itemwarehouses ? $row->itemwarehouses->transform(function ($itemwarehouse) {
                    return [
                        'id' => $itemwarehouse->warehouse_id,
                        'warehouse_description' => $itemwarehouse->warehouse->description ?? 'N/A',
                        'stock' => $itemwarehouse->stock ?? 0
                    ];
                }) : [],
                'lots' => optional($row->item_lots)->where('has_sale', false)->transform(function ($row) {
                    return [
                        'id' => $row->id,
                        'series' => $row->series,
                        'date' => $row->date,
                        'item_id' => $row->item_id,
                        'warehouse_id' => $row->warehouse_id,
                        'has_sale' => (bool)$row->has_sale,
                        'lot_code' => ($row->item_loteable_type) ? (isset($row->item_loteable->lot_code) ? $row->item_loteable->lot_code : null) : null
                    ];
                }) ?? [],
                'lots_group' => collect($row->lots_group)->transform(function ($row) {
                    return [
                        'id'  => $row->id,
                        'code' => $row->code,
                        'quantity' => $row->quantity,
                        'date_of_due' => $row->date_of_due,
                        'checked'  => false
                    ];
                })
            ];
        });
    }

    public function tables_transaction($type)
    {
        return [
            'items' => $this->optionsItemFull(),
            'warehouses' => $this->optionsWarehouse(),
            'inventory_transactions' => $this->optionsInventoryTransaction($type),
        ];
    }

    public function stock(Request $request)
    {
        $configuration = DB::connection('tenant')->table('configurations')->first();

        $id = $request->input('id');
        $item_id = $request->input('item_id');
        $warehouse_id = $request->input('warehouse_id');
        $detail = $request->input('detail');

        $quantity = $request->input('quantity');
        $quantity_real = $request->input('quantity_real');
        $lots = ($request->has('lots')) ? $request->input('lots') : [];

        if ($quantity_real < 0) {
            return [
                'success' => false,
                'message' => 'La cantidad de stock real debe ser mayor o igual a 0'
            ];
        }
        $type = 1;
        $quantity_new = 0;
        $quantity_new = $quantity_real - $quantity;
        if ($quantity_real < $quantity) {
            $quantity_new = $quantity - $quantity_real;
            $type = null;
        }

        $inventory = new Inventory();
        $inventory->type = $type;
        $inventory->description = 'Stock Real';
        $inventory->item_id = $item_id;
        $inventory->warehouse_id = $warehouse_id;
        $inventory->detail = $detail;
        $inventory->quantity = $quantity_new;
        if ($quantity_real < $quantity) {
            $inventory->inventory_transaction_id = 28;
        }

        $inventory->real_stock = $request->quantity_real;
        $inventory->system_stock = $request->quantity;

        $inventory->save();
        $item = Item::findOrFail($item_id);
        $item->stock = $item->stock - $quantity + $quantity_real;
        $item->save();
        $user = auth()->user();
        if ($configuration->number_activity && $configuration->personal_phone == 0) {
            $message = 'El usuario ' . $user->name . ' ha actualizado el stock del producto ' . $item->description . ' a ' . $quantity_real . ' en el almacén ' . $inventory->warehouse->description;
            if ($inventory->detail != null) {
                $message = $message . ' con el comentario ' . $inventory->detail;
            }
            (new WhatsappController)->sendMessage($message);
            $numbers = NumberActivity::all();
            foreach ($numbers as $key => $number) {
                (new WhatsappController)->sendMessage($message, $number->number);
            }
        }


        return [
            'success' => true,
            'message' => 'Cantidad de stock actualizado con éxito'
        ];
    }

    public function regularizarStock(Request $request)
    {
        $warehouse_id = $request->input('warehouse_id');

        if (!$warehouse_id) {
            return response()->json([
                'success' => false,
                'message' => 'El ID del almacén no está presente en la solicitud.'
            ], 400);
        }

        $items = ItemWarehouse::where('stock', '<', 0)
            ->where('warehouse_id', $warehouse_id)
            ->get();
        if ($items->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'No se encontraron productos con stock negativo en el almacén especificado.'
            ]);
        }
        foreach ($items as $item) {

            $quantity_new = abs($item->stock);

            $inventory = new Inventory();
            $inventory->type = 1;
            $inventory->description = 'Stock regularizado';
            $inventory->item_id = $item->item_id;
            $inventory->warehouse_id = $item->warehouse_id;
            $inventory->detail = 'Ajuste a 0 por Rectificación';
            $inventory->quantity = $quantity_new;
            $inventory->inventory_transaction_id = 28;
            $inventory->real_stock = 0;
            $inventory->system_stock = $item->stock;
            $inventory->save();

            $item->stock = 0;
            $item->save();
        }
        return [
            'success' => true,
            'message' => 'stock regularizado con exito'
        ];
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


    public function store_transaction(InventoryRequest $request)
    {
        $result = DB::connection('tenant')->transaction(function () use ($request) {
            // dd($request->all());
            $type = $request->input('type');
            $item_id = $request->input('item_id');
            $warehouse_id = $request->input('warehouse_id');
            $inventory_transaction_id = $request->input('inventory_transaction_id');
            $quantity = $request->input('quantity');
            $lot_code = $request->input('lot_code');
            $lots = ($request->has('lots')) ? $request->input('lots') : [];

            $item_warehouse = ItemWarehouse::firstOrNew([
                'item_id' => $item_id,
                'warehouse_id' => $warehouse_id
            ]);

            if ($type == 'input' && count($lots) > 0) {
                foreach ($lots as $lot) {
                    $existing_lot = ItemLot::where('item_id', $item_id)
                        ->where('warehouse_id', $warehouse_id)
                        ->where('series', $lot['series'])
                        ->whereRaw('LENGTH(series) = ?', [strlen($lot['series'])])
                        ->first();

                    if ($existing_lot) {
                        return [
                            'success' => false,
                            'message' => "La serie {$lot['series']} ya existe para este producto en este almacén no puede registrarse otra vez."
                        ];
                    }
                }
            }

            $inventory_transaction = InventoryTransaction::findOrFail($inventory_transaction_id);

            if ($type == 'output' && ($quantity > $item_warehouse->stock)) {
                return  [
                    'success' => false,
                    'message' => 'La cantidad no puede ser mayor a la que se tiene en el almacén.'
                ];
            }

            $inventory = new Inventory();
            $inventory->type = null;
            $inventory->description = $inventory_transaction->name;
            $inventory->item_id = $item_id;
            $inventory->warehouse_id = $warehouse_id;
            $inventory->quantity = $quantity;
            $inventory->inventory_transaction_id = $inventory_transaction_id;
            $inventory->lot_code = $lot_code;
            $inventory->lots = $lots;
            if ($type == 'output') {
                $lots = array_filter($lots, function ($lot) {
                    return $lot['has_sale'] == true;
                });
                $inventory->lots = $lots;
            }
            $inventory->save();

            $color_size = isset($request->color_size) ? $request->color_size : [];
            $lots_enabled = isset($request->lots_enabled) ? $request->lots_enabled : false;
            if (count($color_size) > 0) {
                $inventory->color_size = $color_size;
            }
            if ($type == 'input') {
                foreach ($color_size as $row) {
                    $stock = $row["stock"];
                    $color = $row["color"];
                    $size = $row["size"];
                    $price = $row["price"];
                    $code = $row["code"];
                    $color_size_exist = ItemColorSize::where('item_id', $item_id)
                        ->where('warehouse_id', $warehouse_id)
                        ->where('color', $color)
                        ->where('size', $size)
                        ->where('code', $code)
                        ->first();
                    if ($color_size_exist) {
                        $color_size_exist->stock = $color_size_exist->stock + $stock;
                        if ($price != null || $price != '' || $price != 0) {
                            $color_size_exist->price = $price;
                        }
                        $color_size_exist->save();
                    } else {
                        ItemColorSize::create([
                            'item_id' => $item_id,
                            'warehouse_id' => $warehouse_id,
                            'stock' => $stock,
                            'color' => $color,
                            'size' => $size,
                            'price' => $price,
                            'code' => $code
                        ]);
                    }
                }
                foreach ($lots as $lot) {

                    $inventory->lots()->create([
                        'date' => $lot['date'],
                        'series' => $lot['series'],
                        'item_id' => $item_id,
                        'warehouse_id' => $warehouse_id,
                        'has_sale' => false,
                        'state' => $lot['state'],
                    ]);
                }

                if ($lots_enabled) {
                    ItemLotsGroup::create([
                        'code'  => $lot_code,
                        'quantity'  => $quantity,
                        'date_of_due'  => $request->date_of_due,
                        'item_id' => $item_id,
                        'warehouse_id' => $warehouse_id
                    ]);
                }

                $item = Item::findOrFail($item_id);
                if ((bool) $item->codes_family) {
                    Log::info('Generando códigos para item_id ' . $item_id . ' en almacén ' . $warehouse_id);
                    ItemCodeService::generateCodesForItemWarehouse($item_id, $warehouse_id);
                }
            } else {
                foreach ($color_size as $row) {
                    if (isset($row["quantity"]) && $row["quantity"] > 0) {
                        $quantity = $row["quantity"];
                        $id = $row["id"];
                        $item_color_size = ItemColorSize::findOrFail($id);
                        $item_color_size->stock = $item_color_size->stock - $quantity;
                        $item_color_size->save();
                    }
                }
                foreach ($lots as $lot) {

                    if ($lot['has_sale']) {

                        $item_lot = ItemLot::findOrFail($lot['id']);
                        // $item_lot->delete();
                        $item_lot->has_sale = true;
                        $item_lot->state = 'Inactivo';
                        $item_lot->save();
                    }
                }

                if (isset($request->IdLoteSelected)) {
                    $lot = ItemLotsGroup::find($request->IdLoteSelected);
                    $lot->quantity = ($lot->quantity - $quantity);
                    $lot->save();
                }
                if (isset($request->lots_group)) {
                    foreach ($request->lots_group as $key => $value) {
                        if ($value["checked"] == true) {
                            $code = $value["code"];
                            $inventory->lot_code = $code;
                            break;
                        }
                    }
                }
            }
            $inventory->save();
            return  [
                'success' => true,
                'message' => ($type == 'input') ? 'Ingreso registrado correctamente' : 'Salida registrada correctamente'
            ];
        });

        return $result;
    }

    public function importColorZise(Request $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '2048M');
        if ($request->hasFile('file')) {
            try {
                $import = new ItemColorSizeImport();
                $import->import($request->file('file'), null, Excel::XLSX);
                $data = $import->getData();

                /*  Log::info('Datos importados:', ['data' => $data]); */

                if (isset($data['items']) && count($data['items']) > 0) {
                    DB::connection('tenant')->transaction(function () use ($data) {
                        foreach ($data['items'] as $row) {
                            /* Log::info('Procesando item:', ['row' => $row]); */

                            $newRequest = new Request();
                            $newRequest->merge($row);

                            $inventoryRequest = InventoryRequest::createFrom($newRequest);
                            /* Log::info('InventoryRequest creado:', ['request' => $inventoryRequest->all()]); */

                            $this->store_transaction($inventoryRequest);
                        }
                    });
                }

                return [
                    'success' => true,
                    'message' => __('app.actions.upload.success'),
                    'data' => $data
                ];
            } catch (Exception $e) {
                /* Log::error('Error en importación:', ['error' => $e->getMessage()]); */
                return [
                    'success' => false,
                    'message' => $e->getMessage()
                ];
            }
        }
        return [
            'success' => false,
            'message' => __('app.actions.upload.error'),
        ];
    }

    public function move(Request $request)
    {
        $result = DB::connection('tenant')->transaction(function () use ($request) {
            // dd($request->all());
            $id = $request->input('id');
            $item_id = $request->input('item_id');
            $warehouse_id = $request->input('warehouse_id');
            $warehouse_new_id = $request->input('warehouse_new_id');
            $quantity = $request->input('quantity');
            $quantity_move = $request->input('quantity_move');
            $lots = ($request->has('lots')) ? $request->input('lots') : [];
            $detail = $request->input('detail');

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
            $inventory->detail = $detail;

            $inventory->save();

            foreach ($lots as $lot) {

                if ($lot['has_sale']) {

                    $item_lot = ItemLot::findOrFail($lot['id']);
                    $item_lot->warehouse_id = $inventory->warehouse_destination_id;
                    $item_lot->update();
                }
            }

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
            // dd($request->all());
            $item_id = $request->input('item_id');
            $warehouse_id = $request->input('warehouse_id');
            $quantity = $request->input('quantity');
            $quantity_remove = $request->input('quantity_remove');
            $lots = ($request->has('lots')) ? $request->input('lots') : [];

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

            foreach ($lots as $lot) {

                if ($lot['has_sale']) {

                    $item_lot = ItemLot::findOrFail($lot['id']);
                    $item_lot->delete();
                }
            }

            return  [
                'success' => true,
                'message' => 'Producto trasladado con éxito'
            ];
        });

        return $result;
    }

    public function initialize()
    {
        $this->initializeInventory();
    }
}
