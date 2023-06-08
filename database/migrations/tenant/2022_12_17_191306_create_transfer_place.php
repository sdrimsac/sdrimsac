<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferPlace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers_place', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10);
            $table->unsignedInteger('warehouse_id');
            $table->unsignedInteger('warehouse_id_destination');
            $table->unsignedInteger('sender_id');
            $table->unsignedInteger('receive_id')->nullable();
            $table->foreign('sender_id')->references('id')->on('users');
            $table->foreign('receive_id')->references('id')->on('users');
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
            $table->foreign('warehouse_id_destination')->references('id')->on('warehouses');
            $table->string('observation', 255);
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('transfers_place');
    }
}
