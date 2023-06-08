<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInternetRegisterTech extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('internet_register', function (Blueprint $table) {
            $table->date('end_date')->nullable()->after('date');
            $table->unsignedInteger('tech_id')->nullable()->after('end_date');
            $table->foreign('tech_id')->references('id')->on('internet_techs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('internet_register', function (Blueprint $table) {
            $table->dropColumn("end_date");
            $table->dropColumn("tech_id");
        });
    }
}
