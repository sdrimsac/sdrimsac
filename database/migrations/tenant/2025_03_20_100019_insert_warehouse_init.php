<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2025_02_18_100010_add_quotation_item_no_found_consolidated_documents
class InsertWarehouseInit extends Migration
{

    public function up()
    {
        Schema::table('cash_init_stock', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('warehouse_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
        });    
    }

    public function down()
    {
        Schema::table('cash_init_stock', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('warehouse_id');

        });
    }
}
