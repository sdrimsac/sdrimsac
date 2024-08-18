<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModuloMantenimiento extends Migration
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
            
            $table->boolean('cuentas_bancarias')->default(true);
            $table->boolean('bancos')->default(true);
            $table->boolean('vendedores')->default(true);
            $table->boolean('registro_actividad')->default(true);
            $table->boolean('categorias')->default(true);
            $table->boolean('marca')->default(true);
            $table->boolean('clientes')->default(true);
            $table->boolean('provedores')->default(true);
            $table->boolean('atributos')->default(true);
            $table->boolean('unidad_medida')->default(true);
            
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
            $table->dropColumn('cuentas_bancarias');
            $table->dropColumn('bancos');
            $table->dropColumn('vendedores');
            $table->dropColumn('registro_actividad');
            $table->dropColumn('categorias');
            $table->dropColumn('marca');
            $table->dropColumn('clientes');
            $table->dropColumn('provedores');
            $table->dropColumn('atributos');
            $table->dropColumn('unidad_medida');
        });  
    }
}