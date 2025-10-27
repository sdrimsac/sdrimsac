<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PersonAttendancesStaffCash extends Migration
{

    public function up()
    {
        Schema::create('person_attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('person_id');
            $table->dateTime('date_time_attendance');
            $table->date('date_attendance');
            $table->time('time_attendance');
            $table->string('type')->nullable();
            $table->string('biometrio')->nullable();
            $table->timestamps();
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('person_attendances');
    }
}
