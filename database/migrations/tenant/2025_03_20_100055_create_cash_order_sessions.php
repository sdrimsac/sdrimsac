<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashOrderSessions extends Migration
{
    public function up()
    {
        Schema::create('cash_order_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cash_id')->nullable();
            $table->unsignedInteger('order_start_id')->nullable();
            $table->unsignedInteger('order_end_id')->nullable();
            $table->boolean('state')->default(1);
            $table->timestamps();

            $table->foreign('cash_id')->references('id')->on('cash')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cash_order_sessions');
    }
}
