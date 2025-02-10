<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2024_10_09_1915307_hotel_rent_payment_add_is_warranty

class HotelRentPaymentAddIsWarranty extends Migration
{
    /**
     * Run the migrations.

     *
     * @return void
     */

    public function up()
    {
        Schema::table('hotel_rent_payments', function (Blueprint $table) {
            $table->boolean('is_warranty')->default(false);


        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotel_rent_payments', function (Blueprint $table) {
            $table->dropColumn([
                'is_warranty',
            ]);
        });
    }
}
