<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferPlaceDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers_place_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('transfers_place_id');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('transfers_place_id')->references('id')->on('transfers_place');
            $table->decimal('quantity', 12, 2)->default("0");
            $table->json('series_lots')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfers_place_detail');
    }
}
