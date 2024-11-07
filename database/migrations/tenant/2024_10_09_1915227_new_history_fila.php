<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewHistoryFila extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('historial', function (Blueprint $table) {
            $table->boolean('estado')->default(false);
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('historial', function (Blueprint $table) {
            $table->dropColumn('estado');
            $table->dropColumn('date_start');
            $table->dropColumn('date_end');
        });   
    } 
}