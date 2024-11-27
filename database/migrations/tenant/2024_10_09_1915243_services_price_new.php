<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//2024_10_09_1915240_add_user_id_inventory_kardex



class ServicesPriceNew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services_details', function (Blueprint $table) {
            $table->string('price_unit')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services_details', function (Blueprint $table) {
            $table->dropColumn('price_unit');
        });
    }
}
