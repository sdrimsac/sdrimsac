<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActiveHotelRentItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotel_rent_items', function (Blueprint $table) {
            $table->boolean('active')->default(1)->after('credit_line');
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
                    $table->dropColumn('active');
            });

     
    }
}
