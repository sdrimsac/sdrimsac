<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2025_03_20_100018_create_user_schedule_appointments_comments
class   CreateUserScheduleAppointmentsComments extends Migration
{

    public function up()
    {
        Schema::create('appointments_comments', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->unsignedBigInteger('user_schedule_appointments');
            $table->foreign('user_schedule_appointments')->references('id')->on('user_schedule_appointments');
            $table->text('comment')->nullable();
            $table->tinyInteger('qualification')->default(0);
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });    
    }

    public function down()
    {
        Schema::dropIfExists('appointments_comments');
    }
}
