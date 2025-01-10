<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('history_clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('number')->nullable();
            $table->unsignedInteger('business_id');
            $table->integer('telephone')->nullable();
            $table->string('direccion')->nullable();
            $table->string('direccion_secondary')->nullable();
            $table->string('email')->nullable();
            $table->string('ruc')->nullable();
            $table->string('user')->nullable();
            $table->string('password')->nullable();
            $table->string('user_secondary')->nullable();
            $table->string('password_secondary')->nullable();
            $table->string('password_certificate')->nullable();
            $table->date('date_certificate')->nullable();
            $table->foreign('business_id')->references('id')->on('business');
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
        Schema::dropIfExists('history_clients');
        Schema::dropIfExists('business');
    }
}
