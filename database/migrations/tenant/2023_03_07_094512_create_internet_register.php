<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternetRegister extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internet_register', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('person_id');
            $table->enum('type', ['fibra', 'antena'])->default('fibra');
            $table->string('installation_address');
            $table->string('reference_installation_address');
            $table->string('identifier')->nullable();
            $table->string('mac')->nullable();
            $table->date('date');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->foreign('person_id')->references('id')->on('persons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internet_register');
    }
}
