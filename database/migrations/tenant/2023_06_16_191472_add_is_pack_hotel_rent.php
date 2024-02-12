<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsPackHotelRent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotel_rents', function (Blueprint $table) {
            $table->boolean('is_pack')->default(false);
            $table->decimal('discount_pack', 12, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            Schema::table('hotel_rents', function (Blueprint $table) {
                    $table->dropColumn('is_pack');
                    $table->dropColumn('discount_pack');
            });

     
    }
}
