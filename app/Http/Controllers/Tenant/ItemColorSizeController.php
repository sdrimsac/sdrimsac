<?php

namespace App\Http\Controllers\Tenant;


use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\ItemColorSizeCollection;
use App\Http\Resources\Tenant\ItemColorSizeResource;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemColorSize;
use App\Models\Tenant\ItemWarehouse;
use Illuminate\Http\Request;

class ItemColorSizeController extends Controller
{
    public function index()
    {
        return view('tenant.item_color_sizes.index');
    }


    public function records(Request $request)
    {
        $records  = ItemColorSize::query();
        $item_id = $request->input('item_id');
        $warehouse_id = $request->input('warehouse_id');
        if ($item_id) {
            $records->where('item_id', $item_id);
        }
        if ($warehouse_id) {
            $records->where('warehouse_id', $warehouse_id);
        }
        $column = $request->input('column');
        $color = $request->input('color');
        $value = $request->input('value');
        if ($color){
            $records->where('color','like',"%{$color}%");
        }
        if ($column && $value) {
            if ($column == 'description') {
                $records->whereHas('item', function ($query) use ($value) {
                    $query->where('description', 'like', "%{$value}%")
                        ->orWhere('internal_id', 'like', "%{$value}%");
                });
            } 
        
            
            else {
                $records->where($column, 'like', "%{$value}%");
            }
        }
        return new ItemColorSizeCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function record($id)
    {
        $record = new ItemColorSizeResource(ItemColorSize::findOrFail($id));
        return $record;
    }
    public function columns()
    {
        return [
            'description' => 'Producto',
            'color' => 'Color',
            'size' => 'Talla',
        ];
    }
    public function delete($id)
    {
        $item_color_size = ItemColorSize::findOrFail($id);
        $item_id = $item_color_size->item_id;
        $item = Item::findOrFail($item_id);
        $item->stock = $item->stock - $item_color_size->stock;
        $warehouse_id = $item_color_size->warehouse_id;
        $warehouse_item = ItemWarehouse::where('item_id', $item_id)->where('warehouse_id', $warehouse_id)->first();
        $warehouse_item->stock = $warehouse_item->stock - $item_color_size->stock;
        $item->save();
        $warehouse_item->save();
        $item_color_size->delete();
        return [
            'success' => true,
            'message' => 'Talla eliminada con éxito'
        ];
    }
}
