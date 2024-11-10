<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FilaMigrateHistoria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicle_feature', function (Blueprint $table) {
            $table->unsignedInteger('historial_id')->nullable();
            $table->foreign('historial_id')->references('id')->on('historial'); 
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