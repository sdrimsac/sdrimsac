<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveItemWarehouseIdHistorial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('historial', 'item_werehouse_id')) {
            Schema::table('historial', function (Blueprint $table) {
                $table->dropForeign(['item_werehouse_id']);
                $table->dropColumn('item_werehouse_id');
            });
        }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {}
}
