<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ExcelHorasExtrasTimes extends Migration
{
    public function up()
    {
        Schema::table('worker_daily_summaries', function (Blueprint $table) {
            if (!Schema::hasColumn('worker_daily_summaries', 'extra_time_two')) {
                $table->time('extra_time_two')->nullable();
            }
            if (!Schema::hasColumn('worker_daily_summaries', 'extra_time_three')) {
                $table->time('extra_time_three')->nullable();
            }
            if (!Schema::hasColumn('worker_daily_summaries', 'lack_time')) {
                $table->time('lack_time')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('worker_daily_summaries', function (Blueprint $table) {
            if (Schema::hasColumn('worker_daily_summaries', 'extra_time_two')) {
                $table->dropColumn('extra_time_two');
            }
            if (Schema::hasColumn('worker_daily_summaries', 'extra_time_three')) {
                $table->dropColumn('extra_time_three');
            }
            if (Schema::hasColumn('worker_daily_summaries', 'lack_time')) {
                $table->dropColumn('lack_time');
            }
        });
    }
}
