<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CalculatePrice extends Migration
{
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->boolean('calculate_price')->default(false);
        });
    }

    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('calculate_price');
        });
    }
}
