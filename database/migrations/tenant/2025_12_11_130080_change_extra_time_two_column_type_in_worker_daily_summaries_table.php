<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeExtraTimeTwoColumnTypeInWorkerDailySummariesTable extends Migration
{
    public function up()
    {
        Schema::table('worker_daily_summaries', function (Blueprint $table) {
            // Cambiar de decimal a time
            $table->time('horas_trabajadas')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('worker_daily_summaries', function (Blueprint $table) {
            // Revertir a decimal (por si haces rollback)
            $table->decimal('horas_trabajadas', 8, 2)->nullable()->change();
        });
    }
}
