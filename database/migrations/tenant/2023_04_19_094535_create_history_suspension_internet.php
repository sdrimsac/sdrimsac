<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorySuspensionInternet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internet_history_suspension', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description', 255);
            $table->date('suspend_date');
            $table->date('reconnect_date')->nullable();
            $table->unsignedInteger('register_id');
            $table->boolean('active')->default(1);
            $table->foreign('register_id')->references('id')->on('internet_register');
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
        Schema::dropIfExists('internet_history_suspension');
    }
}
