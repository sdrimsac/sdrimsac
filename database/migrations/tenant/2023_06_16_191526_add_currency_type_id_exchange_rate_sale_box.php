<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurrencyTypeIdExchangeRateSaleBox extends Migration
{


    public function up()
    {
        Schema::table('boxes', function (Blueprint $table) {
            $table->decimal('exchange_rate_sale', 12, 2)->after('amount')->default(1);
            $table->string('currency_type_id')->after('amount')->default('PEN');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('boxes', function (Blueprint $table) {
            $table->dropColumn('currency_type_id');
            $table->dropColumn('exchange_rate_sale');
        });
    
    }
}
