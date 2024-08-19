<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModuloComprobantePago extends Migration
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
            $table->boolean('listado_boleta_factura_nuevo')->default(true);
            $table->boolean('no_enviados')->default(true);
            $table->boolean('nota_venta')->default(true);
            $table->boolean('nota_credito')->default(true);
            $table->boolean('cotizaciones')->default(true);
            $table->boolean('resumenes')->default(true);
            $table->boolean('anulaciones')->default(true);
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
            $table->dropColumn('listado_boleta_factura_nuevo');
            $table->dropColumn('no_enviados');
            $table->dropColumn('nota_venta');
            $table->dropColumn('nota_credito');
            $table->dropColumn('cotizaciones');
            $table->dropColumn('resumenes');
            $table->dropColumn('anulaciones');
        });  
    }
}