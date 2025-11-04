<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DateEndWorkerAsistenDaily extends Migration
{
    public function up(): void
    {
        Schema::table('worker_daily_summaries', function (Blueprint $table) {
            $table->date('date_end_daily')->nullable();

            
        });
    }

    public function down(): void
    {
        Schema::table('worker_daily_summaries', function (Blueprint $table) {
            if (Schema::hasColumn('worker_daily_summaries', 'date_end_daily')) {
                $table->dropColumn('date_end_daily');
            }
        });
    }
}
