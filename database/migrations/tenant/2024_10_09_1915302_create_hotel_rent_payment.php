<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2024_10_09_1915302_create_hotel_rent_payment

class CreateHotelRentPayment extends Migration
{
    /**
     * Run the migrations.

     *
     * @return void
     */

    public function up()
    {
        Schema::create('hotel_rent_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('hotel_rent_item_id');
            $table->foreign('hotel_rent_item_id')->references('id')->on('hotel_rent_items');
            $table->date('date_payment');
            $table->date('date_start');
            $table->date('date_end');
            $table->decimal('amount', 10, 2);
            $table->boolean('is_paid')->default(false);
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
        Schema::table('hotel_rent_items', function (Blueprint $table) {
            $table->dropColumn([
                'date_payment',
            ]);
        });
    }
}
