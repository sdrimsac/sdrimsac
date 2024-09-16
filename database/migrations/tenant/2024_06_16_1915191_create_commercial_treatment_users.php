<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommercialTreatmentUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercial_treatment_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('commercial_treatment_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();
            $table->foreign('commercial_treatment_id')->references('id')->on('commercial_treatments');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commercial_treatment_users');
    }
}
