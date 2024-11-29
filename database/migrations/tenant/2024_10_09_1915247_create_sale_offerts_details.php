<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//2024_10_09_1915247_create_sale_offerts_details






class CreateSaleOffertsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_offerts_details', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('quantity_total', 10, 2);
            $table->decimal('quantity_free', 10, 2);
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
        Schema::dropIfExists('sale_offerts_details');
    }
}
