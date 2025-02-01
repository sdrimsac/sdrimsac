<?php

namespace App\Http\Resources\Tenant;

use App\Models\System\User;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemWarehouse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;
use App\Models\Tenant\RegisterMovement;
use App\Models\Tenant\Warehouse;
use Illuminate\Support\Facades\DB;

class ItemCatalogCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        $warehouses = Warehouse::select('id', 'description')->get();
        return $this->collection->transform(function ($row, $key) use ($warehouses) {

            $item_warehouses = ItemWarehouse::select('warehouse_id')->where('item_id', $row->id)->get();
            $warehouses_ids = $item_warehouses->pluck('warehouse_id')->toArray();
            $is_in_all_warehouses = count($warehouses_ids) === $warehouses->count();
            
            
            $configuration = Configuration::first();
            $decimal = $configuration->decimal_quantity ?? 2;
            // number_format($number, 2, ',', '.')
            $has_igv_description = null;
            $affectation_igv_types_exonerated_unaffected = ['20', '21', '30', '31', '32', '33', '34', '35', '36', '37'];

            if (in_array($row->sale_affectation_igv_type_id, $affectation_igv_types_exonerated_unaffected)) {

                $has_igv_description = 'No';
            } else {

                $has_igv_description = ((bool) $row->has_igv) ? 'Si' : 'No';
            }
            return [
                //row es una instancia de Item
                'id' => $row->id,
                'unit_type_id' => $row->unit_type_id,
                'description' => $row->description,
                'model' => $row->model,
                'quality' => $row->quality,
                'origin' => $row->origin,
                'name' => $row->name,
                'second_name' => $row->second_name,
                'barcode' => $row->barcode,
                'max_quantity' => $row->max_quantity,
                'warehouse_id' => $row->warehouse_id,
                'internal_id' => $row->internal_id,
                'has_series' =>  (bool)$row->series_enabled,
                'item_code' => $row->item_code,
                'item_code_gs1' => $row->item_code_gs1,
                'location' => $row->location,
                'stock' => $row->getStockByWarehouse(),
                'stock_min' => $row->stock_min,
                'category_id' => $row->category_id,
                'currency_type_id' => $row->currency_type_id,
                'currency_type_symbol' => $row->currency_type->symbol,
                'sale_affectation_igv_type_id' => $row->sale_affectation_igv_type_id,
                'amount_sale_unit_price' => number_format($row->sale_unit_price, $decimal, ".", ""),
                'calculate_quantity' => (bool) $row->calculate_quantity,
                'has_igv' => (bool) $row->has_igv,
                'active' => (bool) $row->active,
                'has_igv_description' => $has_igv_description,
                'sale_unit_price' =>  number_format($row->sale_unit_price, $decimal, ".", ""),
                'created_at' => ($row->created_at) ? $row->created_at->format('Y-m-d H:i:s') : '',
                'updated_at' => ($row->created_at) ? $row->updated_at->format('Y-m-d H:i:s') : '',
                //  'category' => [
                //  'description' =>$row->category->name,
                //  ],
      
                
               /*  'warehouses' => collect($row->warehouses)->transform(function ($row) use ($decimal) {
             
                    return [
                        'id' => $row->id,
                        'warehouse_description' => $row->warehouse->description,
                        'stock' => number_format($row->stock, $decimal, ".", ""),
                        'active' => (bool) $row->active,
                    ];
                }), */
                /* 'warehouse_prices' => collect($row->item_warehouse_prices)->transform(function ($row) use ($decimal) {

                    return [
                        "id" => $row->id,
                        "warehouse_id" => $row->warehouse_id,
                        "price" => number_format($row->price, $decimal, ".", ""),
                        "warehouse" => $row->getWarehouseDescription()
                    ];
                }), */
                /* 'categoria_madera' => ($row->categoria_madera)->transform(function ($row){
                    return [
                        'id' => $row->id,
                        'categoria_madera_description' => $row->categoria_madera->description,
                    ];
                }), */
                'apply_store' => (bool)$row->apply_store,
                'image_url' => ($row->image !== 'imagen-no-disponible.jpg') ? asset('storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'items' . DIRECTORY_SEPARATOR . $row->image) : asset("/logo/{$row->image}"),
                'image_url_medium' => ($row->image_medium !== 'imagen-no-disponible.jpg') ? asset('storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'items' . DIRECTORY_SEPARATOR . $row->image_medium) : asset("/logo/{$row->image_medium}"),
                'image_url_small' => ($row->image_small !== 'imagen-no-disponible.jpg') ? asset('storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'items' . DIRECTORY_SEPARATOR . $row->image_small) : asset("/logo/{$row->image_small}"),
                'is_in_all_warehouses' => $is_in_all_warehouses,

            ];
        });
    }
}
