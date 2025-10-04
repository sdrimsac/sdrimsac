<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class NumberMethodSales extends Migration
{
    public function up()
    {
        Schema::table('sale_note_payments', function (Blueprint $table) {
            $table->string('number_method')->nullable();
        });
    }

    public function down()
    {
        Schema::table('sale_note_payments', function (Blueprint $table) {
            $table->dropColumn('number_method');
        });
    }
}