<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesDeliveriesNew  extends Migration
{
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->increments('id');
            //$table->unsignedBigInteger('orden_id')->nullable();
            $table->unsignedInteger('orden_id')->nullable();
            $table->unsignedInteger('customer_id')->nullable();
            $table->unsignedInteger('table_id')->nullable();
            $table->string('address')->nullable();
            $table->string('reference')->nullable();
            $table->string('telephone')->nullable();
            $table->boolean('status')->default(true)->nullable();
            $table->timestamps();
            $table->foreign('orden_id')->references('id')->on('ordens')->onDelete('set null');
            $table->foreign('table_id')->references('id')->on('tables')->onDelete('set null');
            $table->foreign('customer_id')->references('id')->on('persons')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
}
