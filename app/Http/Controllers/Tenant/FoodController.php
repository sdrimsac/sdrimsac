<?php

namespace Modules\Restaurant\Http\Controllers;

use App\Models\Tenant\Item;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Restaurant\Http\Requests\FoodRequest;
use Modules\Restaurant\Http\Resources\FoodCollection;
use Modules\Restaurant\Models\CategoryFood;
use Modules\Restaurant\Models\Food;

class FoodController extends Controller
{
    public function deleteImage($id)
    {
        $food = Food::find($id);
        $is_delete = Storage::delete($food->image);

        $food->image = null;
        $food->save();

        return [
            'success' => true,
            'message' => 'Imagen borrada'
        ];
    }
    public function uploadImage(Request $request)
    {

        $id = $request->id;

        $food = Food::find($id);
        if ($food->image) {
            $is_delete = Storage::delete($food->image);
            if ($is_delete) {
                $food->image = null;
            }
        }
        if ($request->file) {
            $file = $request->file('file');
            $path = $file->store('public/files');
            $food->image = $path;
        }
        $food->save();

        return [
            'success' => true,
            'message' => 'Imagen subida'
        ];
    }
    public function index()
    {
        $categories = CategoryFood::all();
        $foods = Food::all();
        return view('restaurant::food.food_list', compact('categories', 'foods'));
    }
    public function records()
    {
        $food = new FoodCollection(Food::all());

        return [
            'success' => true,
            'data' => $food
        ];
    }
    public function active($id)
    {
        $food = Food::find($id);
        $food->active = !$food->active;
        $food->save();
        return [
            'success' => true,
            'data' => $food,
            'message' => 'Item ' . ($food->active ? 'activado' : 'desactivado')
        ];
    }
    public function record($id)
    {
        $food = Food::find($id);

        return [
            'success' => true,
            'data' => $food
        ];
    }
    public function store(FoodRequest $request)
    {

        $id = $request->input('id');
        $food = Food::firstOrNew(['id' => $id]);
        $food->fill($request->all());
        if ($request['file']) {
            $file = $request->file('file');
            if ($file != null) {
                $path = $file->store('public/files');
                $food->image = $path;
            }
        }
        //
        $item_id =  $this->itemDefault($food->item_id, $food);
        if ($item_id != 0) {
            $food->item_id = $item_id;
        }
        $food->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Plato / Bebida actualizado(a) con éxito' : 'Plato / Bebida creado(a) con éxito'
        ];
    }
    public function destroy($id)
    {
        //
    }

    public function itemDefault($id, $food)
    {

        $item =  Item::firstOrNew(['id' => $id]);
        $item->description = $food->description;
        $item->sale_unit_price = $food->price;
        $item->image = $food->image ?? 'imagen-no-disponible.jpg';
        $item->image_medium = $food->image ??  'imagen-no-disponible.jpg';
        $item->image_small = $food->image ??  'imagen-no-disponible.jpg';

        if (!$id) {
            $item->item_type_id = '02';
            $item->unit_type_id = 'NIU';
            $item->currency_type_id = 'PEN';
            $item->has_igv = 1;
            $item->purchase_unit_price = 0.0;
            $item->has_isc = 0;
            $item->amount_plastic_bag_taxes = 0.0;
            $item->percentage_isc = 0.0;
            $item->suggested_price = 0.0;
            $item->sale_affectation_igv_type_id = '10';
            $item->purchase_affectation_igv_type_id = '10';
            $item->calculate_quantity = 0;
            $item->is_set = 0;
            $item->is_stock = 1;
            $item->stock = 1;
            $item->stock_min = 1;
            $item->lots_enabled = 0;
            $item->series_enabled = 0;
            $item->percentage_of_profit = 0.0;
            $item->has_perception = 0;
            $item->active = 1;
            $item->status = 1;
            $item->apply_store = 0;
        }
        $item->save();
        if ($item->id) {
            return $item->id;
        }
        return 0;
    }
}
