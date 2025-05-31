<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeriesLotesRelations extends Migration
{
    public function up()
    {
        Schema::table('item_lots', function (Blueprint $table) {
            $table->string('code_lots')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('item_lots', function (Blueprint $table) {
            $table->dropColumn('code_lots');
        });
    }
}
