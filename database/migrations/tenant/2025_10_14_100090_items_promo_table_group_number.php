<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ItemsPromoTableGroupNumber extends Migration
{

    public function up()
    {
        Schema::create('items_promotions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('promotion_item_id');
            $table->decimal('quantity', 8, 2)->default(0);
            $table->decimal('sale_unit_price', 12, 2)->default(0);
            $table->decimal('max_quantity', 12, 2)->default(1);
            $table->integer('group_number')->default(0);
            $table->timestamps();
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('items_promotions');
    }
}
