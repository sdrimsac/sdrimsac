<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ItemHistorialId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('historial_item', function (Blueprint $table) {
            $table->unsignedInteger('historial_id');
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
        Schema::table('historial_item', function (Blueprint $table) {
            $table->dropColumn('historial_id');
           
        });   
    } 
}
