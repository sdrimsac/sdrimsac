<?php

namespace App\Http\Controllers\Tenant;

use Exception;
use App\Models\Tenant\Item;
use App\Models\Tenant\User;
use App\Models\Tenant\Warehouse;
use Illuminate\Support\Str;
use App\Imports\ItemsImport;
use App\Models\Tenant\ItemUnitType;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Models\Tenant\Catalogs\UnitType;
use App\Http\Requests\Tenant\ItemRequest;
use Illuminate\Support\Facades\DB;
use Modules\Format\Models\Account;
use Modules\Restaurant\Models\Area;
use Modules\Restaurant\Models\Food;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\ItemResource;
use App\Models\Tenant\Catalogs\CurrencyType;
use Modules\Item\Models\CategoryItem;
use App\Http\Resources\Tenant\ItemCollection;
use App\Http\Resources\Tenant\ItemPromoResource;
use App\Models\Tenant\Catalogs\AttributeType;
use App\Models\Tenant\Catalogs\SystemIscType;
use Illuminate\Support\Facades\Storage;
use App\Models\Tenant\Catalogs\AffectationIgvType;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\ItemSet;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\ItemWarehousePrice;
use App\Models\Tenant\Kardex;
use App\Models\Tenant\ItemPromotion as ItemPromotionModel;
use Modules\Inventory\Models\Inventory;
use Modules\Inventory\Models\InventoryKardex;
use PSpell\Config;

class PromotionsController extends Controller
{
    public function index()
    {
        return view('tenant.promotions.index');
    }


    public function columns()
    {
        return [
            'description' => 'Nombre',
            'internal_id' => 'Código interno',
        ];
    }

    public function records(Request $request)
    {
        $records = Item::whereTypeUser()
            ->whereIsPromotionItems()
            ->where($request->column, 'like', "%{$request->value}%")
            ->orderBy('description');

        return new ItemCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function create()
    {
        return view('tenant.items.form');
    }
    public function create_internal_id()
    {
        // buscar en items los que tengan la propiedad is_set en 1 y que su internal id empiece con PROM#### (PROM seguido de 4 numeros)
        $item = Item::where('promotions_items', 1)
            ->where('internal_id', 'regexp', '^PROM[0-9]{4}')
            ->orderBy('id', 'desc')
            ->first();

        if ($item === null) {
            return "PROM0001";
        }
        $raw = $item->internal_id ?? '';
        $number_part = substr($raw, 4);
        $number = intval($number_part) + 1;
        $padded = str_pad($number, 4, '0', STR_PAD_LEFT);

        return "PROM{$padded}";
    }
    public function tables()
    {
        $company = Configuration::first();
        $affectation_igv_type_id = $company->affectation_igv_type_id;
        //affectation_igv_types
        $internal_id = $this->create_internal_id();
        $current_affection_igv_types = AffectationIgvType::whereActive()->get();
        $unit_types = UnitType::whereActive()->orderByDescription()->get();
        $currency_types = CurrencyType::whereActive()->orderByDescription()->get();
        $attribute_types = AttributeType::whereActive()->orderByDescription()->get();
        $system_isc_types = SystemIscType::whereActive()->orderByDescription()->get();
        $affectation_igv_types = AffectationIgvType::whereActive()->get();
        $areas = Area::where('active', 1)->get();
        //buscar categoryitem que tenga el nombre PACKS si no existe crearlo
        $category_item = CategoryItem::where('name', 'PACKS')->first();
        if (!$category_item) {
            $category_item = CategoryItem::create([
                'name' => 'PACKS',
                'user_id' => auth()->user()->id
            ]);
        }

        $categories = CategoryItem::all();
        $warehouses = Establishment::all();
        $individual_items = Item::whereWarehouse()->whereTypeUser()->whereNotIsSet()->whereNotPromotionItems()->whereIsActive()->get()->transform(function ($row) {
            $full_description = ($row->internal_id) ? $row->internal_id . ' - ' . $row->description : $row->description;
            return [
                'id' => $row->id,
                'full_description' => $full_description,
                'internal_id' => $row->internal_id,
                'description' => $row->description,
                'sale_unit_price' => $row->sale_unit_price,
            ];
        });

        return compact(
            'internal_id',
            'affectation_igv_type_id',
            'warehouses',
            'unit_types',
            'currency_types',
            'attribute_types',
            'areas',
            'categories',
            'system_isc_types',
            'affectation_igv_types',
            'individual_items'
        );
    }

    public function record($id)
    {
        $record = new ItemPromoResource(Item::findOrFail($id));

        return $record;
    }
    public function item_tables(Request $request)
    {
        $warehouse_id = $request->warehouse_id;
        $input = $request->input;

        // Include all individual items, even those that are part of sets (PACKS)
        // Exclude items that belong to the category named 'INSUMOS'
        $individual_items = Item::whereTypeUser()
            ->whereIsActive()
            ->whereDoesntHave('category', function ($query) {
                $query->where('name', 'INSUMOS');
            });

        if ($input) {
            $individual_items = $individual_items->where(function ($query) use ($input) {
                $query->where('description', 'like', "%{$input}%")
                    ->orWhere('internal_id', 'like', "%{$input}%");
            });
        }

        if ($warehouse_id) {
            $individual_items = $individual_items->whereHas('warehouses', function ($query) use ($warehouse_id) {
                $query->where('warehouse_id', $warehouse_id);
            });
        }

        $individual_items = $individual_items->get()
            ->take(20)
            ->transform(function ($row) {
                $full_description = ($row->internal_id) ? $row->internal_id . ' - ' . $row->description : $row->description;
                $unit_type_description = $row->unit_type->description;
                return [
                    'id' => $row->id,
                    'full_description' => $full_description,
                    'internal_id' => $row->internal_id,
                    'description' => $row->description,
                    'sale_unit_price' => $row->sale_unit_price,
                    'unit_type_description' => $unit_type_description,
                ];
            });

        return compact('individual_items');
    }

    public function store(ItemRequest $request)
    {

        $all_establishment = $request->all_establishment;
        $id = $request->input('id');
        $record = DB::connection('tenant')->transaction(function () use ($request, $id, $all_establishment) {

            $item = Item::firstOrNew(['id' => $id]);
            $item->item_type_id = '01';
            $item->fill($request->all());

            $temp_path = $request->input('temp_path');
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
            } else if (!$request->input('image') && !$request->input('temp_path') && !$request->input('image_url')) {
                $item->image = 'imagen-no-disponible.jpg';
                $food->image = 'imagen-no-disponible.jpg';
            }

            $item->save();
            $item_id = $item->id;

            if ($item_id != 0) {
                $food->item_id = $item_id;
            }
            $food->save();

            if ($request->has('warehouse_prices')) {
                foreach ($request->warehouse_prices as $warehouse_price) {
                    $exists = DB::connection('tenant')
                        ->table('item_warehouse_prices')
                        ->where('item_id', $item_id)
                        ->where('warehouse_id', $warehouse_price['warehouse_id'])
                        ->exists();

                    if ($exists) {
                        DB::connection('tenant')
                            ->table('item_warehouse_prices')
                            ->where('item_id', $item_id)
                            ->where('warehouse_id', $warehouse_price['warehouse_id'])
                            ->update(['price' => $warehouse_price['price']]);
                    } else {
                        DB::connection('tenant')
                            ->table('item_warehouse_prices')
                            ->insert([
                                'item_id' => $item_id,
                                'warehouse_id' => $warehouse_price['warehouse_id'],
                                'price' => $warehouse_price['price']
                            ]);
                    }

                    ItemWarehouse::firstOrCreate(
                        [
                            'item_id' => $item_id,
                            'warehouse_id' => $warehouse_price['warehouse_id']
                        ],
                        ['stock' => 0]
                    );
                }
            }

            if ($all_establishment) {
                $warehouses = Warehouse::all()->pluck('id');
                $stock = $item->stock;
                $new_qty = count($warehouses) * $item->stock;
                $id = $item->id;
                foreach ($warehouses as $wh) {

                    $exist = ItemWarehousePrice::where('warehouse_id', $wh)->where('item_id', $id)->first();
                    if (!isset($exist)) {
                        ItemWarehousePrice::create([
                            'warehouse_id' => $wh,
                            'price' => $item->sale_unit_price,
                            'item_id' => $item->id,
                            'created_at' => date('Y-m-d H:i:s '),
                            'updated_at' => date('Y-m-d H:i:s '),
                        ]);
                    }

                    $exist = ItemWarehouse::where('warehouse_id', $wh)->where('item_id', $id)->first();

                    if (!isset($exist)) {
                        ItemWarehouse::create([
                            'warehouse_id' => $wh,
                            'stock' => $stock,
                            'item_id' => $item->id,
                            'created_at' => date('Y-m-d H:i:s '),
                            'updated_at' => date('Y-m-d H:i:s '),
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

            $item->promotion_items()->delete();
            foreach ($request->promotion_items as $row) {
                $item->promotion_items()->create([
                    'promotion_item_id' => $row['promotion_item_id'],
                    'sale_unit_price' => $row['sale_unit_price'],
                    'quantity' => $row['quantity'],
                    'max_quantity' => $row['max_quantity'] ?? 1,
                ]);
            }
            $item->update();

            return $item;
        });

        return [
            'success' => true,
            'message' => ($id) ? 'Producto compuesto editado con éxito' : 'Producto compuesto registrado con éxito',
            'id' => $record->id
        ];
    }

    public function Warehouses($id)
    {
        $item = Item::findOrFail($id);
        $warehouses = Warehouse::all();

        if ($warehouses->count() > 0) {
            foreach ($warehouses as $warehouse) {
                // Check both tables for existing records
                $exists_warehouse = ItemWarehouse::where('item_id', $id)
                    ->where('warehouse_id', $warehouse->id)
                    ->exists();

                $exists_price = DB::connection('tenant')
                    ->table('item_warehouse_prices')
                    ->where('item_id', $id)
                    ->where('warehouse_id', $warehouse->id)
                    ->exists();

                // Create records if they don't exist in either table
                if (!$exists_warehouse) {
                    ItemWarehouse::create([
                        'item_id' => $id,
                        'warehouse_id' => $warehouse->id,
                        'stock' => 0,
                    ]);
                }

                if (!$exists_price) {
                    DB::connection('tenant')->table('item_warehouse_prices')->insert([
                        'item_id' => $id,
                        'warehouse_id' => $warehouse->id,
                        'price' => $item->sale_unit_price,
                    ]);
                }
            }
        }
        $item_warehouse = ItemWarehouse::where('item_id', $id)->get();
        $item_warehouse->each(function ($row) use ($warehouses) {
            $row->warehouse = $warehouses->where('id', $row->warehouse_id)->first();
        });

        return [
            'success' => true,
            'data' => $item_warehouse
        ];
    }

    public function destroy($id)
    {
        try {

            $item = Item::findOrFail($id);
            $this->deleteRecordInitialKardex($item);
            $item->delete();

            return [
                'success' => true,
                'message' => 'Producto compuesto eliminado con éxito'
            ];
        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false, 'message' => 'El producto compuesto esta siendo usado por otros registros, no puede eliminar'] : ['success' => false, 'message' => 'Error inesperado, no se pudo eliminar el producto compuesto'];
        }
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


    public function import(Request $request)
    {
        if ($request->hasFile('file')) {
            try {
                $import = new ItemsImport();
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

    public function set_item_check_stock($id, $quantity = 1)
    {

        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
        $item_set = ItemSet::where('item_id', $id)->get();
        $message = "";
        $no_stock = false;
        $item_set->each(function ($row) use (&$message, &$no_stock, $quantity, $establishment) {
            $item = Item::find($row->promotion_item_id);
            $item_warehouse = ItemWarehouse::where('item_id', $row->promotion_item_id)->where('warehouse_id', $establishment->id)->first();
            $stock = $item_warehouse->stock;
            $stock_indivual = floatval($row->quantity) * floatval($quantity);
            if ($stock < $stock_indivual) {
                $no_stock = true;
                $difference = $stock_indivual -  $stock;
                $message .= "El producto " . $item->description . " no tiene stock, tiene " . $stock . " y falta " . $difference . "\n";
            }
        });
        if ($no_stock) {
            return [
                'success' => false,
                'message' => $message
            ];
        } else {
            return [
                'success' => true,
                'message' => "El producto compuesto tiene stock suficiente"
            ];
        }
    }

    public function ItemPromotion(Request $request, $id = null)
    {
        // Acepta id por ruta ($id) o por request input 'id' para compatibilidad
        $item_id = $id ?? $request->input('id');

        $result = [];

        if (!$item_id) {
            return $result;
        }

        // Primero ver si $item_id es en realidad un id de fila en items_promotions
        $item_promotion_row = ItemPromotionModel::find($item_id);

        $establishment = Establishment::find(auth()->user()->establishment_id);
        $warehouse_id = $establishment ? $establishment->id : null;

        if ($item_promotion_row) {
            // Se pasó el id de la fila items_promotions: devolver info solo de ese producto
            $quantity = floatval($item_promotion_row->quantity);
            $product_id = $item_promotion_row->promotion_item_id;
            $promo_item = Item::find($product_id);

            // If the promotional product is a recipe (is_set), compute stock based on its ingredients
            $stock = 0;
            $difference = 0;
            $has_stock = true;

            // If the item is a service (unit_type_id == 'ZZ'), it does not control stock => always available
            if ($promo_item && isset($promo_item->unit_type_id) && $promo_item->unit_type_id === 'ZZ') {
                $stock = null;
                $difference = 0;
                $has_stock = true;
            } else if ($promo_item && $promo_item->is_set) {
                // Get recipe ingredients (ItemSet rows)
                $ingredients = ItemSet::where('item_id', $product_id)->get();
                // If no ingredients defined, treat as zero stock
                if ($ingredients->isEmpty()) {
                    $stock = 0;
                } else {
                    $possible_sets = [];
                    foreach ($ingredients as $ing) {
                        $ingredient_id = $ing->individual_item_id;
                        $ingredient_qty = floatval($ing->quantity);
                        if ($ingredient_qty <= 0) {
                            $possible_sets[] = 0;
                            continue;
                        }
                        $ingredient_wh = $warehouse_id ? ItemWarehouse::where('item_id', $ingredient_id)
                            ->where('warehouse_id', $warehouse_id)
                            ->first() : null;
                        $ingredient_stock = $ingredient_wh ? floatval($ingredient_wh->stock) : 0.0;
                        // Compute how many full sets we can make from this ingredient
                        $possible = floor($ingredient_stock / $ingredient_qty);
                        $possible_sets[] = $possible;
                    }
                    // The recipe stock is the minimum possible sets across all ingredients
                    $stock = count($possible_sets) ? min($possible_sets) : 0;
                }
                // Compare available recipe sets with required quantity
                if ($stock < $quantity) {
                    $difference = $quantity - $stock;
                    $has_stock = false;
                }
            } else {
                $item_warehouse = $warehouse_id ? ItemWarehouse::where('item_id', $product_id)
                    ->where('warehouse_id', $warehouse_id)
                    ->first() : null;

                $stock = $item_warehouse ? $item_warehouse->stock : 0;
                if ($stock < $quantity) {
                    $difference = $quantity - $stock;
                    $has_stock = false;
                }
            }

            $result[] = [
                'promotion_item_id' => $product_id,
                // promotion_id should be the id of the promotion (parent item), not the promotion_item id
                'promotion_id' => $item_promotion_row->item_id ?? null,
                'internal_id' => $promo_item ? $promo_item->internal_id : null,
                'description' => $promo_item ? $promo_item->description : "Item ID {$product_id}",
                'quantity_required' => $quantity,
                'sale_unit_price' => isset($item_promotion_row->sale_unit_price) ? $item_promotion_row->sale_unit_price : ($promo_item->sale_unit_price ?? 0),
                'stock_available' => $stock,
                'difference' => $difference,
                'has_stock' => $has_stock,
                'max_quantity' => $item_promotion_row->max_quantity ?? 1,
            ];

            return $result;
        }

        // Si no es una fila de items_promotions, se asume que es el id del Item (promoción)
        $promotion = Item::with('promotion_items.promotion_item')->where('id', $item_id)->first();

        if (!$promotion) return $result;

        foreach ($promotion->promotion_items as $promotion_item) {
            $quantity = floatval($promotion_item->quantity);
            $promo_item = $promotion_item->promotion_item;
            $product_id = $promotion_item->promotion_item_id;

            // If the promo item is a recipe (is_set), compute stock from its ingredients
            $stock = 0;
            $difference = 0;
            $has_stock = true;

            // If the promo item is a service (unit_type_id == 'ZZ'), consider it always available
            if ($promo_item && isset($promo_item->unit_type_id) && $promo_item->unit_type_id === 'ZZ') {
                $stock = null;
                $difference = 0;
                $has_stock = true;
            } else if ($promo_item && $promo_item->is_set) {
                $ingredients = ItemSet::where('item_id', $product_id)->get();
                if ($ingredients->isEmpty()) {
                    $stock = 0;
                } else {
                    $possible_sets = [];
                    foreach ($ingredients as $ing) {
                        $ingredient_id = $ing->individual_item_id;
                        $ingredient_qty = floatval($ing->quantity);
                        if ($ingredient_qty <= 0) {
                            $possible_sets[] = 0;
                            continue;
                        }
                        $ingredient_wh = $warehouse_id ? ItemWarehouse::where('item_id', $ingredient_id)
                            ->where('warehouse_id', $warehouse_id)
                            ->first() : null;
                        $ingredient_stock = $ingredient_wh ? floatval($ingredient_wh->stock) : 0.0;
                        $possible = floor($ingredient_stock / $ingredient_qty);
                        $possible_sets[] = $possible;
                    }
                    $stock = count($possible_sets) ? min($possible_sets) : 0;
                }
                if ($stock < $quantity) {
                    $difference = $quantity - $stock;
                    $has_stock = false;
                }
            } else {
                $item_warehouse = $warehouse_id ? ItemWarehouse::where('item_id', $product_id)
                    ->where('warehouse_id', $warehouse_id)
                    ->first() : null;

                $stock = $item_warehouse ? $item_warehouse->stock : 0;
                if ($stock < $quantity) {
                    $difference = $quantity - $stock;
                    $has_stock = false;
                }
            }

            $result[] = [
                'promotion_item_id' => $product_id,
                // promotion_id is the parent promotion item's id
                'promotion_id' => $promotion->id ?? null,
                'internal_id' => $promo_item ? $promo_item->internal_id : null,
                'description' => $promo_item ? $promo_item->description : "Item ID {$product_id}",
                'quantity_required' => $quantity,
                'sale_unit_price' => isset($promotion_item->sale_unit_price) ? $promotion_item->sale_unit_price : ($promo_item->sale_unit_price ?? 0),
                'stock_available' => $stock,
                'difference' => $difference,
                'has_stock' => $has_stock,
                'max_quantity' => $promotion_item->max_quantity ?? 1,
            ];
        }

        return $result;
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
        $visible = $request->apply_store == true ? 1 : 0;
        $item->apply_store = $visible;
        $item->save();

        return [
            'success' => true,
            'message' => ($visible > 0) ? 'El Producto ya es visible en tienda virtual' : 'El Producto ya no es visible en tienda virtual',
            'id' => $request->id
        ];
    }
}
