<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValidityDatePlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('college_plans', function (Blueprint $table) {

            $table->date('validity_date')->nullable()->after('count');
            $table->date('payment_date')->nullable()->after('count');
            $table->unsignedInteger('penalty_id')->nullable()->after('count');
            $table->foreign('penalty_id')->references('id')->on('college_penalties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('college_plans', function (Blueprint $table) {
            $table->dropColumn('validity_date');
            $table->dropColumn('payment_date');
            $table->dropColumn('penalty_id');
        });
    }
}
