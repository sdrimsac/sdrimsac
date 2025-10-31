<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeEntranceColumnTypeInWorkerDailySummariesTable extends Migration
{

    public function up(): void
    {
        Schema::table('worker_daily_summaries', function (Blueprint $table) {
            $table->time('entrance')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('worker_daily_summaries', function (Blueprint $table) {
            $table->string('entrance')->nullable()->change();
        });
    }
}
