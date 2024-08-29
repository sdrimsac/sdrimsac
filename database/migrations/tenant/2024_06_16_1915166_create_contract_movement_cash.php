<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractMovementCash extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_movement_cash', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['in', 'out']);
            $table->decimal('amount', 10, 2);
            $table->decimal('balance', 10, 2);
            $table->string('observation')->nullable();
            $table->date('date');
            $table->unsignedInteger('contract_product_id');
            $table->foreign('contract_product_id')->references('id')->on('contract_product');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('contract_movement_cash');
    }
}
