<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2024_10_09_1915304_create_hotel_rent_penalties

class CreateHotelRentPenalties extends Migration
{
    /**
     * Run the migrations.

     *
     * @return void
     */


    public function up()
    {
        Schema::create('hotel_rent_penalties', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('hotel_rent_item_id');
            $table->integer('days_late');
            $table->decimal('amount', 12, 2);
            $table->string('status', 20)->default('pending');
            $table->timestamps();
            $table->foreign('hotel_rent_item_id')->references('id')->on('hotel_rent_items');
        });


    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_rent_penalties');
        

    }
}
