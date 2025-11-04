<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPairsToWorkerDailySummaries extends Migration
{
    public function up(): void
    {
        Schema::table('worker_daily_summaries', function (Blueprint $table) {
            if (!Schema::hasColumn('worker_daily_summaries', 'pairs')) {
                $table->json('pairs')->nullable()->after('date_end_daily');
            }
        });
    }

    public function down(): void
    {
        Schema::table('worker_daily_summaries', function (Blueprint $table) {
            if (Schema::hasColumn('worker_daily_summaries', 'pairs')) {
                $table->dropColumn('pairs');
            }
        });
    }
}
