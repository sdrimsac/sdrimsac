<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoriaMaderaSizeDefault extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categoria_madera', function (Blueprint $table) {
            $table->decimal('ancho_default')->nullable();
            $table->decimal('grosor_default')->nullable();
            $table->decimal('largo_default')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categoria_madera', function (Blueprint $table) {
            $table->dropColumn('ancho_default');
            $table->dropColumn('grosor_default');
            $table->dropColumn('largo_default');
        });
    }

    
}
