<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractTotals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_totals', function (Blueprint $table) {
            $table->id();
            $table->decimal('cash', 10, 2);
            $table->decimal('product', 10, 2);
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
        Schema::dropIfExists('contract_totals');
    }
}
