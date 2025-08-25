<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMethodToCashIncomePrincipal extends Migration
{
    public function up()
    {
        Schema::table('cash_income_principal', function (Blueprint $table) {
            $table->string('method')->nullable()->after('amount');
        });
    }

    public function down()
    {
        Schema::table('cash_income_principal', function (Blueprint $table) {
            $table->dropColumn('method');
        });
    }
}
