<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CashOpeningBalances extends Migration
{
    public function up()
    {
        Schema::create('cash_opening_balances', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedInteger('cash_id');
            $table->unsignedInteger('user_id');
            $table->decimal('amount', 15, 2);
            $table->string('method')->nullable();
            $table->timestamps();
            $table->foreign('cash_id')->references('id')->on('cash')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cash_opening_balances');
    }
}
