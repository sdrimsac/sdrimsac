<?php

namespace Modules\Workshop\Http\Resources;

use App\Http\Controllers\Tenant\StoreController;
use App\Models\Tenant\CategoriaMadera;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\ItemCategoriaMadera;
use App\Models\Tenant\ItemUnitType;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\UnitTypePerson;
use App\Models\Tenant\Warehouse;
use Illuminate\Http\Resources\Json\ResourceCollection;

use Modules\Item\Models\ItemLot;
use Modules\Item\Models\ItemLotsGroup;

class FoodCollection extends ResourceCollection
{
    protected $with_series;
    public function __construct($resource, $with_series = false)
    {
        parent::__construct($resource);
        $this->with_series = $with_series;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        $customer_unit_type_id = $request->customer_unit_type_id;
        return $this->collection->transform(function ($row, $key) use ($customer_unit_type_id) {
            
            $user = auth()->user();
            $item = $row->item;
            $has_igv = (bool) $item->has_igv;
            $hasAffectationIgv = $item->hasAffectationIgv();
            $igv = (new StoreController)->getIgvByUser();
            if ($item->lots_enabled && $item->lot_code == null) {
                $lot_group = ItemLotsGroup::where('item_id', $item->id)->first();
                if ($lot_group) {
                    $item->lot_code = $lot_group->code;
                    $item->date_of_due = $lot_group->date_of_due;
                }
            }
            $stock = 0;
            $price = $row->price;

            if (!array_key_exists($user->type, ["admin", "superadmin"])) {
                $warehouse = Warehouse::where('establishment_id', $user->establishment_id)->first();
                $warehouse_id = $warehouse->id;
                $stock = ItemWarehouse::where('warehouse_id', $warehouse_id)->where('item_id', $item->id)->first();
                if ($stock) {
                    $stock = $stock->stock;
                } else {
                    $stock = 0;
                }
                $item->stock = $stock;
            }
            $item_unit_types = [];
            if (count($item->item_warehouse_prices) > 0) {
                $warehouse_price = $item->item_warehouse_prices->where('warehouse_id', $user->establishment_id)->first();
                if ($warehouse_price) {
                    $price = $warehouse_price->price;
                }
            }
            if (count($item->item_unit_types) > 0) {
                $item_types_descp = [];
                if($customer_unit_type_id){
                    $item_types_descp = UnitTypePerson::where('customer_id', $customer_unit_type_id)->pluck('description')->values();
                }
                // $item_unit_types = $item->item_unit_types->where('warehouse_id', $user->establishment_id)->orWhereNull('warehouse_id');
                $item_unit_types = ItemUnitType::where('item_id', $item->id)->where(function ($q) use ($user) {
                    $q->where('warehouse_id', $user->establishment_id)->orWhereNull('warehouse_id');
                });
                if(count($item_types_descp) > 0){
                    $item_unit_types = $item_unit_types->whereIn('description', $item_types_descp);
                }
                $item_unit_types = $item_unit_types->get();
            }
            if ($this->with_series) {
                $lots = ItemLot::where('item_id', $item->id)->where('warehouse_id', $user->establishment_id)
                    ->where('has_sale', false)
                    ->get();
                $stock = count($lots);
                $item->stock = $stock;
            }
            $configuracion = Configuration::first();
            //si el producto no tiene el igv incluido
            if ($configuracion->hasAffectationIgv()) {
                if (!$has_igv) {
                    //si es afectado se le aumenta, sino es afectado el precio se queda igual
                    if ($hasAffectationIgv) {
                        $igv = (new StoreController)->getIgvByUser();
                        $price =  $price * ($igv / 100 + 1);
                    }
                }
                // else {
                //     //si no es afectado se le reduce, si es afectado el precio se queda igual
                //     $igv = (new StoreController)->getIgvByUser();
                //     if (!$hasAffectationIgv) {
                //         $price =  $price / ($igv / 100 + 1);
                //     }
                // }
            }
            $categoria_madera_item = $item->categoria_madera;
            if ($configuracion->consolidated_quotations && !is_array($item_unit_types)) {
                $item_id = $item->id;
                $unit_type = $item_unit_types->first();
                if ($unit_type) {
                    $price = $unit_type->total;
                }
            }
            if ($categoria_madera_item) {
                $item_id = $item->id;
                $categoria_madera = ItemCategoriaMadera::where('item_id', $item_id)->first();
                if ($categoria_madera) {
                    $price = $categoria_madera->precio;
                }
            }
            return [
                'categoria_madera_item' => $categoria_madera_item,
                'id'                => $row->id,
                'description'  => $row->description,
                'code'        => $row->code,
                'category'     => $row->category,
                'image'          => $row->image,
                'stock' => $stock,
                'item' => $item,
                'price' => $price,
                'area_id' => $row->area_id,
                'active' => $row->active,
                'types' => $item_unit_types,
                'series'  => $lots ?? [],
                'second_name' => $item->second_name,
                'currency_type_id' => $item->currency_type_id,
                'currency' => $item->currency_type->symbol,
            ];
        });
    }
}
