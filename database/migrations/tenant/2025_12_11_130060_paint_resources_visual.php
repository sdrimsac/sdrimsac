<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PaintResourcesVisual extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('worker_daily_summaries', 'job_position_id')) {
            Schema::table('worker_daily_summaries', function (Blueprint $table) {
                $table->unsignedBigInteger('job_position_id')->nullable()->after('id');

                $table->foreign('job_position_id')
                    ->references('id')
                    ->on('job_positions')
                    ->onDelete('set null');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('worker_daily_summaries', 'job_position_id')) {
            Schema::table('worker_daily_summaries', function (Blueprint $table) {
                $table->dropForeign(['job_position_id']);
                $table->dropColumn('job_position_id');
            });
        }
    }
}
