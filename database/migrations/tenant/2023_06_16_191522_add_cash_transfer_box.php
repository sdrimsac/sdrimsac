<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCashTransferBox extends Migration
{


    public function up()
    {
        Schema::table('boxes', function (Blueprint $table) {
            $table->unsignedInteger('cash_transfer_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('boxes', function (Blueprint $table) {
            $table->dropColumn('cash_transfer_id');
        });
    }
}
