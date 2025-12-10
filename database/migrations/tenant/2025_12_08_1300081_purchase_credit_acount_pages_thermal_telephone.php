<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PurchaseCreditAcountPagesThermalTelephone extends Migration
{
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            
            $table->boolean('purchase_credit')->default(false);
        });
    }

    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('purchase_credit');
        });
    }
}
