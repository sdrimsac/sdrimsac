<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2024_10_09_1915303_add_hotel_rent_payment_document

class AddHotelRentPaymentDocument extends Migration
{
    /**
     * Run the migrations.

     *
     * @return void
     */

    public function up()
    {
        Schema::table('hotel_rent_documents', function (Blueprint $table) {
            $table->unsignedInteger('hotel_rent_payment_id')->nullable()->after('id');
            $table->foreign('hotel_rent_payment_id')->references('id')->on('hotel_rent_payments');
        });

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotel_rent_documents', function (Blueprint $table) {
            $table->dropForeign(['hotel_rent_payment_id']);
            $table->dropColumn('hotel_rent_payment_id');
        });
    }
}
