<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateWorkerConsumptionsStaff extends Migration
{

    public function up()
    {
        Schema::create('worker_consumptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('person_id');
            $table->decimal('amount', 10, 2);
            $table->dateTime('date_time_consumption');
            $table->string('obervation')->nullable();
            $table->timestamps();
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('worker_consumptions');
    }
}
