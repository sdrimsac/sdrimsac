<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDaysExtensionPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('college_plans', function (Blueprint $table) {
            $table->tinyInteger('days_extension')->default(0)->after('validity_date');
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
            $table->dropColumn("days_extension");
        });
    }
}
