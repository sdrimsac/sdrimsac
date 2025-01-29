<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//2024_10_09_1915294_create_hotel_rent_infraction

class CreateHotelRentInfraction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_rent_infractions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('hotel_rent_id');
            $table->unsignedBigInteger('hotel_rent_document_id')->nullable();
            $table->string('description');
            $table->decimal('amount', 10, 2);
            $table->boolean('paid')->default(false);
            $table->timestamps();
            $table->foreign('hotel_rent_id')->references('id')->on('hotel_rents');
            $table->foreign('hotel_rent_document_id')->references('id')->on('hotel_rent_documents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('hotel_rent_infractions');
    }
}
