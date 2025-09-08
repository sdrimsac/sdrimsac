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
use Illuminate\Support\Collection;

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
        // Load all warehouses once instead of in every iteration
        $warehouses = Warehouse::select('id', 'description')->get();
        $configuration = Configuration::first();
        $decimal = $configuration->decimal_quantity ?? 2;
        $affectation_igv_types_exonerated_unaffected = ['20', '21', '30', '31', '32', '33', '34', '35', '36', '37'];
        
        // Nota: No podemos usar eager loading directo en ResourceCollection como lo haríamos en un modelo
        // porque $this->collection es una instancia de Illuminate\Support\Collection
        
        // Extraemos los IDs de los items para cargar datos relacionados
        $itemIds = $this->collection->pluck('id')->toArray();
        
        // Precargamos los datos de almacén para todos los items de una vez
        $itemWarehousesData = ItemWarehouse::whereIn('item_id', $itemIds)
            ->select('item_id', 'warehouse_id', 'stock')
            ->get()
            ->groupBy('item_id');
            
        // Obtenemos los movimientos de registro para todos los items de una vez
        $lastRegisterMovements = RegisterMovement::whereIn('model_id', $itemIds)
            ->where('model', Item::class)
            ->whereHas('user', function ($query) {
                $query->whereNull('area_id');
            })
            ->select('id', 'model_id', 'user_id', 'description', 'created_at')
            ->with(['user:id,name'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('model_id');
            
        $currentDay = Carbon::now();

        // Precargamos las relaciones comunes para evitar consultas N+1
        // Obtenemos los modelos con sus relaciones precargadas
        $itemsWithRelations = Item::with([
            'unit_type', 
            'currency_type', 
            'warehouses.warehouse', 
            'item_warehouse_prices', 
            'item_unit_types', 
            'item_codes'
        ])->whereIn('id', $itemIds)->get()->keyBy('id');

        return $this->collection->transform(function ($row, $key) use (
            $warehouses, 
            $decimal, 
            $affectation_igv_types_exonerated_unaffected, 
            $itemWarehousesData,
            $lastRegisterMovements,
            $currentDay,
            $itemsWithRelations
        ) {
            // Si tenemos una versión con relaciones precargadas, la usamos
            if (isset($itemsWithRelations[$row->id])) {
                $row = $itemsWithRelations[$row->id];
            }
            
            // Get item warehouses data efficiently
            $warehousesForItem = $itemWarehousesData[$row->id] ?? collect();
            $warehouses_ids = $warehousesForItem->pluck('warehouse_id')->toArray();
            $is_in_all_warehouses = !empty($warehouses_ids) && count($warehouses_ids) === $warehouses->count();
            
            // Calculate has_igv_description efficiently
            $has_igv_description = in_array($row->sale_affectation_igv_type_id, $affectation_igv_types_exonerated_unaffected) 
                ? 'No' 
                : (((bool) $row->has_igv) ? 'Si' : 'No');
            
            // Process item unit types once
            $item_unit_types = !isset($row->item_unit_types) || $row->item_unit_types->isEmpty() ? [] : $row->item_unit_types->map(function ($unit_type) {
                return [
                    'total' => $unit_type->total,
                    'unit_type_id' => $unit_type->unit_type_id,
                    'description' => $unit_type->description,
                    'quantity_unit' => $unit_type->quantity_unit,
                    'price1' => $unit_type->price1,
                    'price2' => $unit_type->price2,
                    'price3' => $unit_type->price3,
                    'price_default' => $unit_type->price_default,
                ];
            });
            
            // Process item codes once
            $item_codes = !isset($row->item_codes) || $row->item_codes->isEmpty() ? [] : $row->item_codes->map(function ($code) {
                return [
                    'item_id' => $code->item_id,
                    'code_barcode' => $code->code_barcode,
                    'is_primary' => $code->is_primary,
                    'active' => $code->active,
                ];
            });
            
            // Get last document data efficiently
            $last_register = $this->get_last_document_optimized($row, $lastRegisterMovements, $currentDay);

            // Construct image URLs once
            $image_url = $this->getImageUrl($row->image, 'items');
            $image_url_medium = $this->getImageUrl($row->image_medium, 'items');
            $image_url_small = $this->getImageUrl($row->image_small, 'items');
            
            return [
                'calculate_price' => (bool)$row->calculate_price,
                'codes_family' => $row->codes_family,
                'commission' => $row->commission,
                'last_register' => $last_register,
                'init_report' => $row->init_report,
                'has_warranty' => $row->has_warranty,
                'month_day' => $row->month_day,
                'has_color_size' => (bool)$row->has_color_size,
                'max_quantity_description' => $row->max_quantity_description,
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
                'has_series' => (bool)$row->series_enabled,
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
                'sale_unit_price' => number_format($row->sale_unit_price, $decimal, ".", ""),
                'purchase_unit_price' => "{$row->currency_type->symbol} " . number_format($row->purchase_unit_price, $decimal, '.', ''),
                'created_at' => ($row->created_at) ? $row->created_at->format('Y-m-d H:i:s') : '',
                'updated_at' => ($row->created_at) ? $row->updated_at->format('Y-m-d H:i:s') : '',
                'unit_type_description' => ($row->unit_type) ? $row->unit_type->description : '',
                'unit_type' => $item_unit_types,
                'item_codes' => $item_codes,
                'warehouses' => isset($row->warehouses) ? $row->warehouses->map(function ($warehouse) use ($decimal) {
                    return [
                        'id' => $warehouse->id,
                        'warehouse_description' => $warehouse->warehouse->description,
                        'stock' => number_format($warehouse->stock, $decimal, ".", ""),
                        'active' => (bool) $warehouse->active,
                    ];
                }) : collect(),
                'warehouse_prices' => isset($row->item_warehouse_prices) ? $row->item_warehouse_prices->map(function ($price) use ($decimal) {
                    return [
                        "id" => $price->id,
                        "warehouse_id" => $price->warehouse_id,
                        "price" => number_format($price->price, $decimal, ".", ""),
                        "warehouse" => $price->getWarehouseDescription()
                    ];
                }) : collect(),
                'apply_store' => (bool)$row->apply_store,
                'image_url' => $image_url,
                'image_url_medium' => $image_url_medium,
                'image_url_small' => $image_url_small,
                'is_in_all_warehouses' => $is_in_all_warehouses,
            ];
        });
    }

    /**
     * Get the image URL for an item
     * 
     * @param string $image
     * @param string $folder
     * @return string
     */
    private function getImageUrl($image, $folder)
    {
        if ($image !== 'imagen-no-disponible.jpg') {
            return asset('storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $image);
        }
        
        return asset("/logo/{$image}");
    }

    /**
     * Get last document data without additional queries
     * 
     * @param App\Models\Tenant\Item $row
     * @param Collection $lastRegisterMovements
     * @param Carbon\Carbon $currentDay
     * @return array
     */
    private function get_last_document_optimized($row, $lastRegisterMovements, $currentDay)
    {
        $data = [
            'user' => '',
            'date_time' => '',
            'description' => '',
            'created_at' => ''
        ];
        
        if (isset($lastRegisterMovements[$row->id]) && $lastRegisterMovements[$row->id]->isNotEmpty()) {
            $last_register_movement = $lastRegisterMovements[$row->id]->first();
            $date_time = $last_register_movement->created_at;
            
            $data = [
                'user' => $last_register_movement->user->name,
                'description' => $last_register_movement->description,
                'date_time' => $this->get_date_difference_optimized($date_time, $currentDay),
                'created_at' => $date_time->format('Y-m-d H:i:s')
            ];
        }
        
        return $data;
    }

    /**
     * Calculate date difference optimized
     * 
     * @param Carbon\Carbon $created_at
     * @param Carbon\Carbon $currentDay
     * @return array
     */
    private function get_date_difference_optimized($created_at, $currentDay)
    {
        $difference = $created_at->diff($currentDay);
        $days = $difference->days;
        
        return [
            'is24Hours' => $days > 0,
            'days' => $days,
            'hours' => $difference->h,
            'minutes' => $difference->i,
            'seconds' => $difference->s
        ];
    }
}
