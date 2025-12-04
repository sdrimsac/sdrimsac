<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SchedulesPerson extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('schedules')) {
            Schema::create('schedules', function (Blueprint $table) {

                $table->id("id");
                $table->unsignedInteger('person_id');
                $table->string('name')->nullable();
                $table->time('entrada');
                $table->time('salida');
                $table->integer('tolerancia_min')->default(0);

                $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
