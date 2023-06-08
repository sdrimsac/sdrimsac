<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollegeSchoolSupplies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('college_school_supplies', function (Blueprint $table) {
            $table->bigIncrements('s_supp_id');
            $table->string('s_supp_name');
            $table->string('s_supp_brand');
            $table->integer('s_supp_status');
            $table->string('s_supp_codigo');
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
        Schema::dropIfExists('college_school_supplies');
    }
}
