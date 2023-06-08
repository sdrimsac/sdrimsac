<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViewDailyCash extends Migration
{
    
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('view_daily_cash')->default(true);
            $table->boolean('view_daily_cash_pin')->default(false);
            $table->boolean('send_whatsapp_daily_cash')->default(false);
        });
    }

  
    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('view_daily_cash');
            $table->dropColumn('view_daily_cash_pin');
            $table->dropColumn('send_whatsapp_daily_cash');
        });
    }
}
