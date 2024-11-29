<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//2024_10_09_1915249_create_unit_type_price_range







class CreateUnitTypePriceRange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_unit_type_price_ranges', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('unit_type_id');
            $table->foreign('unit_type_id')->references('id')->on('item_unit_types');
            $table->decimal('quantity_min', 10, 2);
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_unit_type_price_ranges');
        
    }
}
