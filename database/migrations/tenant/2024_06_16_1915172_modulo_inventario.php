<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModuloInventario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            //
            
            $table->boolean('listado_productos')->default(true);
            $table->boolean('guias_remision')->default(true);
            $table->boolean('promocion_oferta')->default(true);
            $table->boolean('ingreso_salida_productos')->default(true);
            $table->boolean('tipo_transacciones_inventario')->default(true);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('listado_productos');
            $table->dropColumn('guias_remision');
            $table->dropColumn('promocion_oferta');
            $table->dropColumn('ingreso_salida_productos');
            $table->dropColumn('tipo_transacciones_inventario');
        });  
    }
}