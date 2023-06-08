<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollegeListSupplies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('college_list_supplies', function (Blueprint $table) {
            $table->bigIncrements('list_supp_id');
            $table->unsignedBigInteger('list_supp_s_supp_id');
            $table->unsignedInteger('list_supp_classroom_id');
            $table->integer('list_supp_cantidad');
            $table->timestamps();

            $table->foreign('list_supp_s_supp_id')->references('s_supp_id')->on('college_school_supplies');
            $table->foreign('list_supp_classroom_id')->references('id')->on('college_classrooms');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('college_list_supplies');
    }
}
