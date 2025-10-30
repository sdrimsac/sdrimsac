<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CashStockMovements extends Migration
{

    public function up()
    {
        Schema::create('cash_stock_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('cash_id')->nullable();
            $table->unsignedInteger('item_id')->nullable();
            $table->unsignedInteger('warehouse_id')->nullable();
            $table->decimal('initial_stock', 18, 3)->default(0);
            $table->decimal('purchases', 18, 3)->default(0);
            $table->decimal('sold_quantity', 18, 3)->default(0);
            $table->decimal('current_stock', 18, 3)->default(0);
            $table->string('movement_type')->nullable();
            $table->timestamps();
            $table->foreign('cash_id')->references('id')->on('cash')->onDelete('cascade');
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cash_stock_movements');
    }
}
