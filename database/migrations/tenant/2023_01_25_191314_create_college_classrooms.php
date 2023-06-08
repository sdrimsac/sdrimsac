<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollegeClassrooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('college_classrooms', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('degree_id');
            $table->unsignedInteger('turn_id');
            $table->unsignedInteger('section_id');
            $table->unsignedInteger('level_id');
            $table->integer('places');
            $table->date('year');
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->foreign('degree_id')->references('id')->on('college_degrees');
            $table->foreign('level_id')->references('id')->on('college_levels');
            $table->foreign('section_id')->references('id')->on('college_sections');
            $table->foreign('turn_id')->references('id')->on('college_turns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('college_classrooms');
    }
}
