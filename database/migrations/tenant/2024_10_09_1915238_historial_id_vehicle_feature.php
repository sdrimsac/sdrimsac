<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//2024_10_09_1915237_add_price_item_unit_type
//2024_10_09_1915238_historial_id_vehicle_feature

Class HistorialIdVehicleFeature extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicle_feature', function (Blueprint $table) {
            if (!Schema::hasColumn('vehicle_feature', 'historial_id')) {
                $table->unsignedInteger('historial_id')->nullable();
            }
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicle_feature', function (Blueprint $table) {
            $table->dropColumn('historial_id');
        });
    }
}
