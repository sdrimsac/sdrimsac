<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DoctorTablesTimer extends Migration
{

    public function up()
    {
        Schema::create('dental_medic_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('medic_id')->nullable();
            $table->enum('day_of_week', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);
            $table->time('start_time');
            $table->time('end_time');
            $table->string('active')->nullable();
            $table->timestamps();
            $table->foreign('medic_id')->references('id')->on('medic')->onDelete('cascade');
        });

        Schema::create('dental_medic_exceptions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('medic_id')->nullable();
            $table->enum('day_of_week', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['available', 'unavailable'])->default('unavailable');
            $table->string('active')->nullable();
            $table->timestamps();
            $table->foreign('medic_id')->references('id')->on('medic')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dental_medic_details');
        Schema::dropIfExists('dental_medic_exceptions');
    }
}
