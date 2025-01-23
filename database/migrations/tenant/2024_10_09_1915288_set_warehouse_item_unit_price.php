<?php

use App\Models\Tenant\Warehouse;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
//2024_10_09_1915288_set_warehouse_item_unit_price
class SetWarehouseItemUnitPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $first_warehouse = Warehouse::first();
        if($first_warehouse){
            $warehouse_id = $first_warehouse->id;
            DB::connection('tenant')->table('item_unit_types')->where('warehouse_id', null)->update(['warehouse_id' => $warehouse_id]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
