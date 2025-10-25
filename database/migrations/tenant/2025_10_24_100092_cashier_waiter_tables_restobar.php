<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CashierWaiterTablesRestobar extends Migration
{

    public function up()
    {
        Schema::create('cashier_waiter', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('cashier_id');
            $table->unsignedInteger('waiter_id');
            $table->unsignedInteger('establishment_id');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->foreign('cashier_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('waiter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('establishment_id')->references('id')->on('establishments')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('cashier_waiter');
    }
}
