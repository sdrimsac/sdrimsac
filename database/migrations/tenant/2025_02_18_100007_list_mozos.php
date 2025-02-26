<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ListMozos extends Migration
{
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('seller_mozo')->default(false);
        });
    }

    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('seller_mozo');
        });
    }
}
