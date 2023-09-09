<?php

namespace Modules\Restaurant\Http\Resources;

use App\Models\Tenant\ItemUnitType;
use App\Models\Tenant\ItemWarehouse;
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
        return $this->collection->transform(function ($row, $key) {
            $user = auth()->user();
            $item = $row->item;
            if($item->lots_enabled && $item->lot_code == null){
                $lot_group = ItemLotsGroup::where('item_id', $item->id)->first();
                if($lot_group){
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
                if($stock){
                    $stock = $stock->stock;
                }else{
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
                // $item_unit_types = $item->item_unit_types->where('warehouse_id', $user->establishment_id)->orWhereNull('warehouse_id');
                $item_unit_types = ItemUnitType::where('item_id', $item->id)->where(function ($q) use ($user) {
                    $q->where('warehouse_id', $user->establishment_id)->orWhereNull('warehouse_id');
                })->get();
            }
            if($this->with_series){
                $lots = ItemLot::where('item_id',$item->id)->where('warehouse_id', $user->establishment_id)
                ->where('has_sale', false)
                ->get();
                $stock = count($lots);
                $item->stock = $stock;
            }
            return [
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
            ];
        });
    }
}
