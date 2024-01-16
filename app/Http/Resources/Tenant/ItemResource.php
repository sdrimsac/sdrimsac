<?php

namespace App\Http\Resources\Tenant;

use Modules\Restaurant\Models\Food;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Item\Models\ItemLotsGroup;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $foods = Food::where('item_id', $this->id)->first();
        $lot_code = null;
        $date_of_due = null;
        if($this->lots_enabled){
            $lot_group = ItemLotsGroup::where('item_id', $this->id)->first();

            if($lot_group){
                $lot_code = $lot_group->code;
                $date_of_due = $lot_group->date_of_due;
            }
     
        }

        return [
            'is_manufactured' => (bool) $this->is_manufactured,
            'max_quantity_description' => $this->max_quantity_description,
            'id' => $this->id,
            'max_quantity' => $this->max_quantity,
            'delivery_cost' => $this->delivery_cost,
            'description' => $this->description,
            'name' => $this->name,
            'barcode' => $this->barcode,
            'second_name' => $this->second_name,
            'location' => $this->location,
            'warehouse_id' => $this->warehouse_id,
            'internal_id' => $this->internal_id,
            'item_code' => $this->item_code,
            'item_code_gsl' => $this->item_code_gsl,
            'currency_type_id' => $this->currency_type_id,
            'sale_unit_price' => $this->sale_unit_price,
            'purchase_unit_price' => $this->purchase_unit_price,
            'unit_type_id' => $this->unit_type_id,
            'has_isc' => (bool) $this->has_isc,
            'system_isc_type_id' => $this->system_isc_type_id,
            'percentage_isc' => $this->percentage_isc,
            'suggested_price' => $this->suggested_price,
            'stock' => $this->getStockByWarehouse(),
            'stock_min' => $this->stock_min,
            'percentage_of_profit' => $this->percentage_of_profit,
            'sale_affectation_igv_type_id' => $this->sale_affectation_igv_type_id,
            'purchase_affectation_igv_type_id' => $this->purchase_affectation_igv_type_id,
            'calculate_quantity' => (bool) $this->calculate_quantity,
            'has_igv' => (bool) $this->has_igv,
            'has_perception' => (bool) $this->has_perception,
            'lots_enabled' => (bool) $this->lots_enabled,
            'percentage_perception' => $this->percentage_perception,
            'item_unit_types' => $this->item_unit_types,
            'image' => $this->image,
            'account_id' => $this->account_id,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'date_of_due' => $date_of_due,
            'image_url' => ($this->image !== 'imagen-no-disponible.jpg') ? asset('storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'items' . DIRECTORY_SEPARATOR . $this->image) : asset("/logo/{$this->image}"),
            'individual_items' => $this->sets->transform(function ($row, $key) {
                $full_description = ($row->individual_item->internal_id) ? $row->individual_item->internal_id . ' - ' . $row->individual_item->description : $row->individual_item->description;
                return [
                    'id' => $row->id,
                    'item_id' => $row->item_id,
                    'individual_item_id' => $row->individual_item_id,
                    'full_description' => $full_description,
                    'sale_unit_price' => (float) $row->individual_item->sale_unit_price,
                    'quantity' => (float) $row->quantity,
                    'unit_type_description' => $row->individual_item->unit_type->description,
                ];
            }),
            'area_id' => ($foods == null) ? null : $foods->area_id,
            'apply_store' => (bool)$this->apply_store,
            //  'individual_items' => collect($this->sets)->pluck('individual_item_id'),
            'commission_amount' => $this->commission_amount,
            'lot_code' => $lot_code,
            'lots' => $this->lots->transform(function ($row, $key) {
                return [
                    'id' => $row->id,
                    'series' => $row->series,
                    'date' => $row->date,
                    'item_id' => $row->item_id,
                    'warehouse_id' => $row->warehouse_id,
                    'item_loteable_type' => $row->item_loteable_type,
                    'item_loteable_id' => $row->item_loteable_id,
                    'has_sale' => $row->has_sale,
                    'state' => $row->state,
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,
                    'deleted' => false
                ];
            }),
            'commission_type' => $this->commission_type ?? 'amount',
            'attributes' => $this->attributes ? $this->attributes : [],
            'warehouse_prices' => collect($this->item_warehouse_prices)->transform(function ($row) {

                return [
                    "id" => $row->id,
                    "warehouse_id" => $row->warehouse_id,
                    "price" => $row->price,
                    "warehouse" => $row->getWarehouseDescription()
                ];
            }),
            'series_enabled' => $this->series_enabled,
            'is_promotion' => (bool) $this-> is_promotion , 
            'promotion_count' => $this-> promotion_count,

            // 'warehouses' => collect($this->warehouses)->transform(function($row) {
            //     return [
            //         'warehouse_description' => $row->warehouse->description,
            //         'stock' => $row->stock,
            //     ];
            // })
        ];
    }
}
