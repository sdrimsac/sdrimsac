<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Configuration;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ItemCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->collection->transform(function ($row, $key) {
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
            if ($row->unit_type == null) {
                $item_unit_types = [];
            } else {
                $item_unit_types = collect($row->item_unit_types)->transform(function ($row) {
                    return [
                        'unit_type_id' => $row->unit_type_id,
                        'description' => $row->description,
                        'quantity_unit' => $row->quantity_unit,
                        'price1' => $row->price1,
                        'price2' => $row->price2,
                        'price3' => $row->price3,
                        'price_default' => $row->price_default,
                    ];
                });
            }
            return [
                'id' => $row->id,
                'unit_type_id' => $row->unit_type_id,
                'description' => $row->description,
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
                'sale_unit_price' => "{$row->currency_type->symbol} " . number_format($row->sale_unit_price, $decimal, ".", ""),
                'purchase_unit_price' => "{$row->currency_type->symbol} " . number_format($row->purchase_unit_price, $decimal, '.', ''),
                'created_at' => ($row->created_at) ? $row->created_at->format('Y-m-d H:i:s') : '',
                'updated_at' => ($row->created_at) ? $row->updated_at->format('Y-m-d H:i:s') : '',
                //  'category' => [
                //  'description' =>$row->category->name,
                //  ],
                'unit_type' => $item_unit_types,
                'warehouses' => collect($row->warehouses)->transform(function ($row) use ($decimal) {
                    return [ //
                        'id' => $row->id,
                        'warehouse_description' => $row->warehouse->description,
                        'stock' => number_format($row->stock, $decimal, ".", ""),
                    ];
                }),
                'warehouse_prices' => collect($row->item_warehouse_prices)->transform(function ($row) use ($decimal) {

                    return [
                        "id" => $row->id,
                        "warehouse_id" => $row->warehouse_id,
                        "price" => number_format($row->price, $decimal, ".", ""),
                        "warehouse" => $row->getWarehouseDescription()
                    ];
                }),
                'apply_store' => (bool)$row->apply_store,
                'image_url' => ($row->image !== 'imagen-no-disponible.jpg') ? asset('storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'items' . DIRECTORY_SEPARATOR . $row->image) : asset("/logo/{$row->image}"),
                'image_url_medium' => ($row->image_medium !== 'imagen-no-disponible.jpg') ? asset('storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'items' . DIRECTORY_SEPARATOR . $row->image_medium) : asset("/logo/{$row->image_medium}"),
                'image_url_small' => ($row->image_small !== 'imagen-no-disponible.jpg') ? asset('storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'items' . DIRECTORY_SEPARATOR . $row->image_small) : asset("/logo/{$row->image_small}"),

            ];
        });
    }
}
