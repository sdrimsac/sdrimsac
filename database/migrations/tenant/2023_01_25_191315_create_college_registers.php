<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollegeRegisters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('college_registers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('member_id');
            $table->unsignedInteger('plan_id');
            $table->unsignedInteger('classroom_id');
            $table->date('first_pay');
            $table->date('last_pay');
            $table->integer('payment_count');
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('plan_id')->references('id')->on('college_plans');
            $table->foreign('classroom_id')->references('id')->on('college_classrooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('college_registers');
    }
}
