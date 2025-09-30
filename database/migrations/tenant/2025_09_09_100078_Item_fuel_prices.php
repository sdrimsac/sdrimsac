<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ItemFuelPrices extends Migration
{
    public function up()
    {
        Schema::create('item_totem_prices', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedInteger('item_id');
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('user_id')->nullable();
            $table->date('date_of_price')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_totem_prices');
    }
}
