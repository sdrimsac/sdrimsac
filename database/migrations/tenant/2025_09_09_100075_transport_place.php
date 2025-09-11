<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TransportPlace extends Migration
{
    public function up()
    {
        Schema::create('transport_places', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedInteger('customer_id')->nullable();
            $table->string('plate')->nullable();
            $table->string('vehicle')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('persons')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transport_places');
    }
}
