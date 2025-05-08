<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class   SaleEstablishmentCredit extends Migration
{
    public function up()
    {
        Schema::table('establishments', function (Blueprint $table) {
            $table->boolean('credit_warehouse')->default(false);
        });
    }

    public function down()
    {
        Schema::table('establishments', function (Blueprint $table) {
            $table->dropColumn('credit_warehouse');
        });
    }
}
