<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EtiquetasConfig extends Migration
{
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('model_01')->default(true);
            $table->boolean('model_02')->default(true);
            $table->boolean('model_03')->default(true);
            $table->boolean('model_04')->default(true);
            $table->boolean('model_05')->default(true);
            $table->boolean('model_06')->default(true);
            $table->boolean('model_07')->default(true);
            $table->boolean('model_08')->default(true);
            $table->boolean('model_09')->default(true);
        });
    }
    
    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('model_01');
            $table->dropColumn('model_02');
            $table->dropColumn('model_03');
            $table->dropColumn('model_04');
            $table->dropColumn('model_05');
            $table->dropColumn('model_06');
            $table->dropColumn('model_07');
            $table->dropColumn('model_08');
            $table->dropColumn('model_09');
        });
    }
}
