<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//2024_10_09_1915268_establishments_notification_numbers

class EstablishmentsNotificationNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('establishments_notification_numbers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('establishment_id');
            $table->unsignedInteger('number');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('establishments_notification_numbers');
    }
}
