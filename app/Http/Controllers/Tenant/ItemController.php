<?php

namespace App\Http\Controllers\Tenant;

use Exception;
use Mpdf\Mpdf;
use App\Models\Tenant\Item;
use App\Models\Tenant\User;
use App\Models\Tenant\Company;
use Mpdf\HTMLParserMode;
use App\Models\Tenant\Inventory;
use App\Models\Tenant\ItemImage;
use App\Models\Tenant\Warehouse;

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
use App\Http\Resources\Tenant\ItemStockCollection;
use App\Http\Resources\Tenant\ItemResource;
use App\Models\Tenant\Catalogs\CurrencyType;
use App\Http\Resources\Tenant\ItemCollection;
use App\Imports\ItemsPriceImport;
use App\Models\Tenant\Catalogs\AttributeType;
use App\Models\Tenant\Catalogs\SystemIscType;
use Modules\Item\Models\ItemLotsGroup;
use Illuminate\Support\Facades\Storage;
use App\Models\Tenant\Catalogs\AffectationIgvType;
use App\Models\Tenant\InventoryKardex;
use App\Models\Tenant\ItemWarehousePrice;
use App\Models\Tenant\Kardex;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Inventory\Models\Warehouse as WarehouseModule;


class ItemController extends Controller
{
    public function index()
    {

        return view('tenant.items.index');
    }

    public function index_ecommerce()
    {
        return view('tenant.items_ecommerce.index');
    }

    public function columns()
    {
        return [
            'description' => 'Nombre | Cód. Int. | Nombre Sec. ',
            'category' => 'Categoria',
            'barcode' => 'Código de barras',
            'brand' => 'Marca',
            'date_of_due' => 'Fecha vencimiento',
            'lot_code' => 'Código lote',
            'active' => 'Habilitados',
            'inactive' => 'Inhabilitados',
            // 'description' => 'Descripción'
        ];
    }

    public function generateCode()
    {
        $new_code = "";
        $item = Item::where('internal_id', 'like', '9%')->whereRaw('LENGTH(internal_id) = 8')->orderBy('internal_id', 'desc')->first();
        if (!$item) {
            $new_code = "90000000";
        } else {
            $new_code = intval($item->internal_id) + 1;
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
    public function getRecords($request)
    {
        $datos = $request->value;
        $textoIntoArray =  explode(' ', $datos);

        switch ($request->column) {

            case 'brand':
                $records = Item::whereHas('brand', function ($q) use ($request) {
                    $q->where('name', 'like', "%{$request->value}%");
                })
                    ->whereTypeUser()
                    ->whereNotIsSet();
                break;

            case 'active':
                $records = Item::whereTypeUser()
                    ->whereNotIsSet()
                    ->whereIsActive();
                break;

            case 'inactive':
                $records = Item::whereTypeUser()
                    ->whereNotIsSet()
                    ->whereIsNotActive();
                break;
            case 'description':
                if (count($textoIntoArray) === 1) {
                    $records = Item::whereTypeUser()
                        ->whereNotIsSet()
                        ->where('description', 'like', "%{$request->value}%")
                        ->orWhere('internal_id', 'like', "%{$request->value}%")
                        ->orWhere('second_name', 'like', "%{$request->value}%");
                    break;
                } else {
                    $records = Item::whereTypeUser()
                        ->whereNotIsSet();
                    foreach ($textoIntoArray as $key => $value) {
                        $records->where('description', 'like', '%' . $value . '%');
                    }

                    break;
                }

            case 'category':
                $records = Item::whereTypeUser()
                    ->whereNotIsSet()
                    ->whereHas('category', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->value . '%');
                    });
                break;
            default:
                $records = Item::whereTypeUser()
                    ->whereNotIsSet()
                    ->where($request->column, 'like', "%{$request->value}%");
                break;
        }


        return $records->orderBy('description');
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
        $unit_types = UnitType::whereActive()->orderByDescription()->get();
        $currency_types = CurrencyType::whereActive()->orderByDescription()->get();
        $attribute_types = AttributeType::whereActive()->orderByDescription()->get();
        $system_isc_types = SystemIscType::whereActive()->orderByDescription()->get();
        $affectation_igv_types = AffectationIgvType::whereActive()->get();
        $areas = Area::all();
        // $warehouse = Warehouse::where('establishment_id', auth()->user()->establishment_id)->first();
        $warehouses = Warehouse::all();
        $accounts = Account::all();
        $payment_method_types = PaymentMethodType::all();
        $categories = CategoryItem::all();

        $brands = Brand::all();
        $configuration = Configuration::select(
            'init_stock',
            'affectation_igv_type_id',
            'restaurant',
            'promotions_sell'
        )->firstOrFail();


        return compact(
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
            'configuration'
        );
    }

    public function record($id)
    {
        $record = new ItemResource(Item::findOrFail($id));

        return $record;
    }


    public function store(ItemRequest $request)
    {
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

                    ]);
                }
            }
            $item->stock = $new_qty;
            $item->save();
        }
        ItemUnitType::where('item_id', $item->id)->delete();
        ItemWarehousePrice::where('item_id', $item->id)->delete();
        //---------------------------------------
        if ($request['item_unit_types'] != null) {
            foreach ($request['item_unit_types'] as $unit) {
                $newUnitType = new ItemUnitType;
                $newUnitType->fill($unit);
                $newUnitType->item_id = $item->id;
                $newUnitType->save();
            }
        }
        if ($request['warehouse_prices'] != null) {
            foreach ($request['warehouse_prices'] as $w) {
                if ($w["price"] != null) {

                    $warehouse_price = new ItemWarehousePrice;
                    $warehouse_price->warehouse_id = $w["warehouse_id"];
                    $warehouse_price->item_id = $item->id;
                    $warehouse_price->price = $w["price"];
                    $warehouse_price->save();
                }
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

        //---------------------------------
        if ($request['file']) {

            // $file = $request->file('file');
            // if ($file != null) {
            //     $path = $file->store('public/files');
            //     $food->image = $path;
            // }
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
            // $item->lots()->delete();
            $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
            $warehouse = Warehouse::where('establishment_id', $establishment->id)->first();
            $v_lots = isset($request->lots) ? $request->lots : [];
        }

        // $directory = 'public'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'items'.DIRECTORY_SEPARATOR;
        // $multi_images = isset($request->multi_images) ? $request->multi_images:[];
        // foreach ($multi_images as $im) {
        //     $file_name = $im['filename'];
        //     $file_content = file_get_contents($im['temp_path']);
        //     Storage::put($directory.$file_name, $file_content);

        //     ItemImage::create(['item_id'=> $item->id, 'image' => $file_name]);
        // }

        $item->update();

        return [
            'success' => true,
            'message' => ($id) ? 'Producto editado con éxito' : 'Producto registrado con éxito',
            'id' => $item->id,
            'data' => $item
        ];
    }

    public function destroy($id)
    {
        try {

            $item = Item::findOrFail($id);
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
            return ($e->getCode() == '23000') ? ['success' => false, 'message' => 'El producto esta siendo usado por otros registros, no puede eliminar'] : ['success' => false, 'message' => 'Error inesperado, no se pudo eliminar el producto'];
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


    public function import_prices(Request $request)
    {
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
}
