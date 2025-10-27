<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateWorkerAdvances extends Migration
{

    public function up()
    {
        Schema::create('worker_advances', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('person_id');
            $table->decimal('amount', 10, 2);
            $table->string('method');
            $table->dateTime('date_time_advance');
            $table->string('obervation')->nullable();
            $table->timestamps();
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('worker_advances');
    }
}
