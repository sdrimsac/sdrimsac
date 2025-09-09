<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AnulateRentItemsHotel extends Migration
{
    public function up()
    {
        Schema::table('hotel_rent_items', function (Blueprint $table) {
            $table->string('motive_anulate')->nullable();
        });
    }

    public function down()
    {
        Schema::table('hotel_rent_items', function (Blueprint $table) {
            $table->dropColumn('motive_anulate');
        });
    }
}
