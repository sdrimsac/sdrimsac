<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenaltyServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('college_penalty_services', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('penalty_id');
            $table->unsignedInteger('item_id');
            $table->decimal('price');
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->foreign('penalty_id')->references('id')->on('college_penalties');
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
        Schema::dropIfExists('college_penalty_services');
    }
}
