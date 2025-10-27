<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class WorkerDailyTablesTrabajadores extends Migration
{

    public function up()
    {
        Schema::create('worker_daily_summaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('person_id');
            $table->date('entrance');
            $table->time('exit');
            $table->decimal('horas_trabajadas', 5, 2);
            $table->decimal('overtime', 5, 2);
            $table->decimal('amount_extra', 5, 2);
            $table->boolean('lack')->default(false);
            $table->timestamps();
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('worker_daily_summaries');
    }
}
