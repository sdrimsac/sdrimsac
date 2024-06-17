<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConfigurableImpresionTicketCategoriaCaja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('configurable_impresion_ticket_categoria_caja')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            
            Schema::table('configurations', function (Blueprint $table) {
                $table->dropColumn('configurable_impresion_ticket_categoria_caja');
            });
        
    }
}
