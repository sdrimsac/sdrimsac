<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class   EnterDateTimeWorker extends Migration
{

    public function up()
    {
        Schema::table('worker_daily_summaries', function (Blueprint $table) {
            $table->date('date_daily');
        });
    }

    public function down()
    {
        Schema::table('worker_daily_summaries', function (Blueprint $table) {
            $table->dropColumn('date_daily');
        });
    }
}
