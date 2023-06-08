<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollegePlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('college_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('description', 200);
            $table->unsignedInteger('period_id');
            $table->unsignedInteger('type_id')->nullable();
            $table->integer('count');
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->foreign('period_id')->references('id')->on('college_periods');
            $table->foreign('type_id')->references('id')->on('college_plan_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('college_plans');
    }
}
