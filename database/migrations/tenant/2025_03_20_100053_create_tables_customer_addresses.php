<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesCustomerAddresses extends Migration
{
    public function up()
    {
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id')->nullable();
            $table->string('address')->nullable();
            $table->string('reference')->nullable();
            $table->string('alias')->nullable();
            $table->string('telephone')->nullable();
            $table->boolean('status')->default(true)->nullable();
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('persons')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_addresses');
    }
}
