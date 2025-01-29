<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//2024_10_09_1915293_add_due_date_hotel_document

class AddDueDateHotelDocument extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotel_rent_documents', function (Blueprint $table) {

            $table->date('due_date')->nullable();
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
            $table->dropColumn('due_date');
        });
    }
}
