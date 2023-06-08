<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollegeTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('college_teachers', function (Blueprint $table) {
            $table->increments('teach_id');
            $table->unsignedInteger('teach_pers_id');
            $table->integer('active');
            $table->timestamps();

          
            $table->foreign('teach_pers_id')->references('id')->on('persons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('college_teachers');
    }
}
