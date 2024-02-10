<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFactorQuantityInsumoHotel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('insumos_hotels', function (Blueprint $table) {
            $table->boolean('days_factor')->default(false);
            $table->boolean('persons_factor')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('insumos_hotels', function (Blueprint $table) {
            $table->dropColumn('days_factor');
            $table->dropColumn('persons_factor');
        });
    }
}
