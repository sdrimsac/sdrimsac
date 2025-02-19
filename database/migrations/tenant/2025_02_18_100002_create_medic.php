<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedic extends Migration
{
    public function up()
    {
        Schema::create('medic', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('specialty_id');
            $table->string('name');
            $table->string('number');
            $table->string('country_id');
            $table->string('department_id')->nullable();
            $table->string('province_id')->nullable();
            $table->string('district_id')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('sexo')->nullable();
            $table->timestamps();

            $table->foreign('specialty_id')
                  ->references('id')
                  ->on('specialties')
                  ->onDelete('cascade');
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('medic');
    }
} 