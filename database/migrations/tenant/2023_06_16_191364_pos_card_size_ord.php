<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PosCardSizeOrd extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('trunc_txt')->default(true)->after('decimal_quantity')->comment('Truncar texto y alargar tarjeta');
            $table->boolean('ord_dscp')->default(true)->after('decimal_quantity')->comment('Ordenar por descripcion');
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
            $table->dropColumn('trunc_txt');
            $table->dropColumn('ord_dscp');
        });
     
    }
}
