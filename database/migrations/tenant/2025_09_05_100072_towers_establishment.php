<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TowersEstablishment extends Migration
{
    public function up()
    {
        Schema::table('towers', function (Blueprint $table) {
            $table->unsignedInteger('establishment_id')->nullable()->after('id');
            $table->foreign('establishment_id')->references('id')->on('establishments')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('towers', function (Blueprint $table) {
            $table->dropForeign(['establishment_id']);
            $table->dropColumn('establishment_id');
        });
    }
}
