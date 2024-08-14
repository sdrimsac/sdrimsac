<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductosVendidos extends Migration
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
            
            $table->boolean('productos_vendidos')->default(true);
            $table->boolean('reporte_caja')->default(true);
            $table->boolean('reporte_cierre_caja')->default(true);
            $table->boolean('reporte_globalizado')->default(true);
            $table->boolean('reporte_metodos_pago')->default(true);
            $table->boolean('reporte_ganancias')->default(true);
            $table->boolean('reporte_productos')->default(true);
            $table->boolean('stock_valorizado')->default(true);
            $table->boolean('stock_minimo')->default(true);
            $table->boolean('stock_producto')->default(true);
            $table->boolean('kardex')->default(true);
            $table->boolean('reporte_series_vendidas')->default(true);
            
            
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
            $table->dropColumn('productos_vendidos');
            $table->dropColumn('reporte_caja');
            $table->dropColumn('reporte_cierre_caja');
            $table->dropColumn('reporte_globalizado');
            $table->dropColumn('reporte_metodos_pago');
            $table->dropColumn('reporte_ganancias');
            $table->dropColumn('reporte_productos');
            $table->dropColumn('stock_valorizado');
            $table->dropColumn('stock_minimo');
            $table->dropColumn('stock_producto');
            $table->dropColumn('kardex');
            $table->dropColumn('reporte_series_vendidas');
        });  
    }
}