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
use App\Models\Tenant\Catalogs\AttributeType;
use App\Models\Tenant\Catalogs\SystemIscType;
use Illuminate\Support\Facades\Storage;
use App\Models\Tenant\Catalogs\AffectationIgvType;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\ItemSet;
use App\Models\Tenant\ItemWarehouse;
use PSpell\Config;

class ItemSetController extends Controller
{
    public function index()
    {
        return view('tenant.item_sets.index');
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
            ->whereIsSet()
            ->where($request->column, 'like', "%{$request->value}%")
            ->orderBy('description');

        return new ItemCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function create()
    {
        return view('tenant.items.form');
    }
    function create_internal_id(){
        //buscar en items los que tengan la propiedad is_set en 1 y que su internal id empiece con pack#### osea pack seguido de 4 numeros
        $item = Item::where('is_set', 1)
        ->where('internal_id', 'regexp', '^PACK[0-9]{4}')
        ->orderBy('id', 'desc')
        ->first();
        ;
        if($item == null){
            return "PACK0001";
        }else{
            $internal_id = $item->internal_id;
            $internal_id = substr($internal_id, 4);
            $internal_id = intval($internal_id);
            $internal_id++;
            $internal_id = str_pad($internal_id, 4, "0", STR_PAD_LEFT);
            return "PACK".$internal_id;
        }
    
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
        $individual_items = Item::whereWarehouse()->whereTypeUser()->whereNotIsSet()->whereIsActive()->get()->transform(function ($row) {
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
            'warehouses','unit_types', 'currency_types', 'attribute_types', 'areas', 'categories', 'system_isc_types', 'affectation_igv_types', 'individual_items');
    }

    public function record($id)
    {
        $record = new ItemResource(Item::findOrFail($id));

        return $record;
    }
    public function item_tables(Request $request)
    {
        $warehouse_id = $request->warehouse_id;
        $input = $request->input;
        
        $individual_items = Item::whereTypeUser()->whereNotIsSet()->whereIsActive();
        if($input){
            $individual_items = $individual_items->where(function($query) use($input){
                $query->where('description', 'like', "%{$input}%")
                ->orWhere('internal_id', 'like', "%{$input}%");
            });
        }
        if($warehouse_id){
            $individual_items = $individual_items->whereHas('warehouses', function($query) use($warehouse_id){
                $query->where('warehouse_id', $warehouse_id);
            });
        }
        $individual_items =  $individual_items->get()
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

        $id = $request->input('id');
        //    dd($request->all());
        $record = DB::connection('tenant')->transaction(function () use ($request, $id) {

            $item = Item::firstOrNew(['id' => $id]);
            $item->item_type_id = '01';
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
            } else if (!$request->input('image') && !$request->input('temp_path') && !$request->input('image_url')) {
                $item->image = 'imagen-no-disponible.jpg';
                $food->image = 'imagen-no-disponible.jpg';
            }


            $item->save();
            $item_id =  $item->id;
            if ($item_id != 0) {
                $food->item_id = $item_id;
            }
            $food->save();
            $item->sets()->delete();
            foreach ($request->individual_items as $row) {
                $item->sets()->create([
                    'individual_item_id' => $row['individual_item_id'],
                    'sale_unit_price' => $row['sale_unit_price'],
                    'quantity' => $row['quantity'],
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

    public function set_item_check_stock($id,$quantity = 1)
    {

        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
        $item_set = ItemSet::where('item_id', $id)->get();
        $message = "";
        $no_stock = false;
        $item_set->each(function ($row) use (&$message,&$no_stock,$quantity,$establishment) {
            $item = Item::find($row->individual_item_id);
            $item_warehouse = ItemWarehouse::where('item_id', $row->individual_item_id)->where('warehouse_id', $establishment->id)->first();
            $stock = $item_warehouse->stock;
            $stock_indivual = floatval($row->quantity) * floatval($quantity);
            if ($stock < $stock_indivual) {
                $no_stock = true;
                $difference = $stock_indivual -  $stock;
                $message .= "El producto " . $item->description . " no tiene stock, tiene ".$stock." y falta ".$difference."\n";
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
