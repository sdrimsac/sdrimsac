<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VerOrdensMozoId extends Migration
{
    public function up()
    {
        Schema::table('ordens', function (Blueprint $table) {

            $table->unsignedInteger('mozo_id')->nullable();

            $table->foreign('mozo_id')->references('id')->on('seller_mozo');
        });
    }

    public function down()
    {
        Schema::table('ordens', function (Blueprint $table) {
            $table->dropColumn('mozo_id');
        });
    }
}
