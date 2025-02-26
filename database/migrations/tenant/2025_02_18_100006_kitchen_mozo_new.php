<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KitchenMozoNew extends Migration
{
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('kitchen_mozo')->default(false);
        });
    }

    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('kitchen_mozo');
        });
    }
}
