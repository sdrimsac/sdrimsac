<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NuevoComprobanteElectronico extends Migration
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
            $table->boolean('nuevo_comprobante_electronico')->default(true);
            
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
            $table->dropColumn('nuevo_comprobante_electronico');
            
        });  
    }
}