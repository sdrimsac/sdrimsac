<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWarehouseLotGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_lots_group', function (Blueprint $table) {
            $table->unsignedInteger('warehouse_id')->nullable()->before('created_at');
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
            // $table->boolean("show_stock_establishment_box")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_lots_group', function (Blueprint $table) {
            $table->dropColumn('warehouse_id');
            // $table->date('date_of_due')->nullable(false)->change();
        });
    }
}
