<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2024_10_09_1915304_create_hotel_rent_penalties_settings

class CreateHotelRentPenaltiesSettings extends Migration
{
    /**
     * Run the migrations.

     *
     * @return void
     */

    //  CREATE TABLE penalty_settings (
    //     id bigint unsigned NOT NULL AUTO_INCREMENT,
    //     table_type_id bigint unsigned NOT NULL,
    //     amount_per_day decimal(12,2) NOT NULL,
    //     grace_period_days int DEFAULT 0,
    //     active boolean DEFAULT true,
    //     created_at timestamp NULL,
    //     updated_at timestamp NULL,
    //     PRIMARY KEY (id),
    //     FOREIGN KEY (table_type_id) REFERENCES table_types(id)
    // );

    public function up()
    {
        Schema::create('hotel_rent_penalties_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('table_type_id')->nullable();
            $table->decimal('amount_per_day', 12, 2);
            $table->boolean('is_percentage')->default(true);
            $table->integer('grace_period_days')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('table_type_id')->references('id')->on('table_types');
        });

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_rent_penalties_settings');
        
    }
}
