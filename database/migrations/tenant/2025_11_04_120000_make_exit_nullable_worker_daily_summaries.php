<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeExitNullableWorkerDailySummaries extends Migration
{
    public function up(): void
    {
        Schema::table('worker_daily_summaries', function (Blueprint $table) {
            if (Schema::hasColumn('worker_daily_summaries', 'exit')) {
                $table->time('exit')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('worker_daily_summaries', function (Blueprint $table) {
            if (Schema::hasColumn('worker_daily_summaries', 'exit')) {
                $table->time('exit')->nullable(false)->change();
            }
        });
    }
}
