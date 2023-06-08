<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdensDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        

        Schema::create('ordens_delete', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('orden_id')->nullable();
            $table->unsignedInteger('orden_item_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->string("reason",255)->nullable();
            $table->json('data')->nullable();
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
        Schema::dropIfExists('ordens_delete');

    }
}
