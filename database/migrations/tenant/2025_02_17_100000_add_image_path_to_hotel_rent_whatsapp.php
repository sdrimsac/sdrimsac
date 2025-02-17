<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImagePathToHotelRentWhatsapp extends Migration
{
    public function up()
    {
        Schema::table('hotel_rent_whatsapp', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('active');
        });
    }

    public function down()
    {
        Schema::table('hotel_rent_whatsapp', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }
} 