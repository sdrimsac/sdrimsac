<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

//2024_10_09_1915274_migracion_active_options
class MigracionActiveOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Get deactivated items
        $deactivatedItems = DB::connection('tenant')->table('items')->where('active', 0)->pluck('id');

        // Deactivate item_warehouse records
        DB::connection('tenant')->table('item_warehouse')->whereIn('item_id', $deactivatedItems)->update(['active' => 0]);

        // Activate deactivated items
        DB::connection('tenant')->table('items')->whereIn('id', $deactivatedItems)->update(['active' => 1]);
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
