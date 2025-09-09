<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HoskiperWorkersClean extends Migration
{
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('cleaning_tower')->default(false);
        });
    }

    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('cleaning_tower');
        });
    }
}
