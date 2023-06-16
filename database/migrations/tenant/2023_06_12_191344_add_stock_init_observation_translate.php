<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStockInitObservationTranslate extends Migration
{
    
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('init_stock')->default(false);
            $table->boolean('observation_translate')->default(false);
        });
    }

  
    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('init_stock');
            $table->dropColumn('observation_translate');
        });
    }
}
