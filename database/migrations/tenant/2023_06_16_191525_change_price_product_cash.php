<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePriceProductCash extends Migration
{


    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('change_price_product')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('change_price_product');
        });
    }
}
