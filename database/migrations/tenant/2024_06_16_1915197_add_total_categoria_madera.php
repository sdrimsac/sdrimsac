<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalCategoriaMadera extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categoria_madera', function (Blueprint $table) {
            $table->boolean('sum_totals')->default(false);
        
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categoria_madera', function (Blueprint $table) {
            $table->dropColumn('sum_totals');
        });
        
    }
}
