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

            $item_warehouses = ItemWarehouse::select('warehouse_id')
                ->where('item_id', $row->id)
                ->where('active', 1)
                ->get();
            $warehouses_ids = $item_warehouses->pluck('warehouse_id')->toArray();
            $is_in_all_warehouses = count($warehouses_ids) === $warehouses->count();
            
            
            $configuration = Configuration::first();
            $decimal = $configuration->decimal_quantity ?? 2;
            
            return [
                //row es una instancia de Item
                'id' => $row->id,
                'unit_type_id' => $row->unit_type_id,
                'description' => $row->description,
                'warehouse_id' => $row->warehouse_id,
                'internal_id' => $row->internal_id,
                'stock' => $row->getStockByWarehouse(),
                'category_id' => $row->category_id,
                'currency_type_id' => $row->currency_type_id,
                'currency_type_symbol' => $row->currency_type->symbol,
                'sale_affectation_igv_type_id' => $row->sale_affectation_igv_type_id,
                'amount_sale_unit_price' => number_format($row->sale_unit_price, $decimal, ".", ""),
                'sale_unit_price' =>  number_format($row->sale_unit_price, $decimal, ".", ""),
                'image_url' => ($row->image !== 'imagen-no-disponible.jpg') ? asset('storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'items' . DIRECTORY_SEPARATOR . $row->image) : asset("/logo/{$row->image}"),
                'created_at' => ($row->created_at) ? $row->created_at->format('Y-m-d H:i:s') : '',
                'updated_at' => ($row->created_at) ? $row->updated_at->format('Y-m-d H:i:s') : '',
            ];
        });
    }
}
