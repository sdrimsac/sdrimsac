<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EstablishmentInOrders extends Migration
{
    public function up()
    {
        Schema::table('cash_order_sessions', function (Blueprint $table) {
            $table->unsignedInteger('establishment_id')->nullable()->after('id');
            $table->foreign('establishment_id')->references('id')->on('establishments')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('cash_order_sessions', function (Blueprint $table) {
            $table->dropForeign(['establishment_id']);
            $table->dropColumn('establishment_id');
        });
    }
}
