<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternetPaymentMonth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internet_payment_month', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('month');
            $table->unsignedInteger('payment_id');
            $table->date('year')->nullable();
            $table->timestamps();
            $table->foreign('payment_id')->references('id')->on('internet_payments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internet_payment_month');
    }
}
