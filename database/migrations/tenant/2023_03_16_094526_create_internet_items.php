<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternetItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internet_item', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('register_id');
            $table->unsignedInteger('item_id');
            $table->decimal('quantity');
            $table->json('series')->nullable();
            $table->timestamps();
            $table->foreign('register_id')->references('id')->on('internet_register');
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internet_item');
    }
}
