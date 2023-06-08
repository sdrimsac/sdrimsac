<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BoxesDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boxes_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_detail_id');
            $table->decimal('quantity', 16, 6)->default(0);
            $table->decimal('price', 16, 6)->default(0);
            $table->decimal('price_extra', 16, 6)->default(0);
            $table->unsignedInteger('boxes_id');
            $table->foreign('item_detail_id')->references('id')->on('expenses_incomes_items');
            $table->foreign('boxes_id')->references('id')->on('boxes');
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
        Schema::dropIfExists('boxes_detail');
    }
}
