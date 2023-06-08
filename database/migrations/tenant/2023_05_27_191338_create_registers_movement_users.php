<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistersMovementUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        

        Schema::create('registers_movement_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string("event",15);
            $table->string("description",255);
            $table->string("ip",25);
            $table->string("browser",15)->nullable();
            $table->string("model",255)->nullable();
            $table->unsignedInteger("model_id")->nullable();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('registers_movement_users');

    }
}
