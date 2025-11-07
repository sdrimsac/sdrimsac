<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkerCaminoVidaSummaryCorrelativesTable extends Migration
{
    public function up()
    {
        Schema::create('summary_correlatives', function (Blueprint $table) {
            $table->id();
            $table->string('ruc', 11);
            $table->enum('type', ['RC','RA']);
            $table->integer('correlative')->default(0);
            $table->string('origin_app')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('summary_correlatives');
    }
}

