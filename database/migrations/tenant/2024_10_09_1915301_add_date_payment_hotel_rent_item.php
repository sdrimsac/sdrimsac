<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2024_10_09_1915301_add_date_payment_hotel_rent_item

class AddDatePaymentHotelRentItem extends Migration
{
    /**
     * Run the migrations.

     *
     * @return void
     */

    public function up()
    {
        Schema::table('hotel_rent_items', function (Blueprint $table) {
            $table->date('date_payment')->nullable()->after('duration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotel_rent_items', function (Blueprint $table) {
            $table->dropColumn([
                'date_payment',
            ]);
        });
    }
}
