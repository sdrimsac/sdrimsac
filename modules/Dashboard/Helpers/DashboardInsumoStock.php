<?php

namespace Modules\Dashboard\Helpers;

use Illuminate\Support\Facades\DB;
use Modules\Inventory\Models\ItemWarehouse;
use Modules\Dashboard\Http\Resources\DashboardInsumoStockCollection;

class DashboardInsumoStock
{

    public function data($request)
    { 
        return $this->stock_insumos_products($request);
    }
    
    private function stock_insumos_products($request)
    {
        $products = ItemWarehouse::whereHas('item', function($query) {
            $query->whereNotIsSet()
              ->where('status', true)
              ->where('unit_type_id', '!=', 'ZZ')
              ->where('init_report', 1);
        })
        ->with(['item', 'cash_registers' => function($query) {
            $query->whereHas('cash', function($q) {
            $q->where('state', true); // For open cash registers
            });
        }])
        ->where('stock', '<=', 20)
        ->select([
            'id',
            'item_id',
            'warehouse_id',
            'stock',
            DB::raw('(SELECT COALESCE(SUM(quantity), 0) FROM cash_register_items 
                 WHERE item_warehouse_id = item_warehouse.id 
                 AND cash_id IN (SELECT id FROM cash WHERE state = true)) as used_stock')
        ])
        ->orderBy('stock')
        ->paginate(config('tenant.items_per_page_simple_d_table'));
                    
        return new DashboardInsumoStockCollection($products);
    }
 
}