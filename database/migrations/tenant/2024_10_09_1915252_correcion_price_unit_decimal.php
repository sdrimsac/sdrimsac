<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//2024_10_09_1915247_create_sale_offerts_details

class CorrecionPriceUnitDecimal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services_details', function (Blueprint $table) {
            // Modificar el tipo de la columna 'price_unit' a decimal
            $table->decimal('price_unit', 10, 2)->change();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    /* public function down()
    {
        Schema::dropIfExists('commits');
    } */
    public function down()
    {
        Schema::table('services_details', function (Blueprint $table) {
            // Si necesitas revertir la migración, vuelve a 'string'
            $table->string('price_unit')->nullable()->change();
        });
    }
}
