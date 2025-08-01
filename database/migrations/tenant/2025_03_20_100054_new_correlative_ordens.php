<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewCorrelativeOrdens extends Migration
{
    public function up()
    {
        Schema::table('ordens', function (Blueprint $table) {

            $table->boolean('to_delivery')->default(false);
            $table->unsignedInteger('correlative')->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('ordens', function (Blueprint $table) {
            $table->dropColumn(['correlative', 'to_delivery']);
        });
    }
}
