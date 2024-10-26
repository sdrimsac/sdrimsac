<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FilaDiagnostico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('historial', function (Blueprint $table) {
            $table->boolean('reparacion')->default(false);
            $table->boolean('garantia')->default(false);
            $table->boolean('mantenimiento')->default(false);
            $table->boolean('diagnostico')->default(false);
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
            $table->dropColumn('reparacion');
            $table->dropColumn('garantia');
            $table->dropColumn('mantenimiento');
            $table->dropColumn('diagnostico');
        });   
    } 
}
