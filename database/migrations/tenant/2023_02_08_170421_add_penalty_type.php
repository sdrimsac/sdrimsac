<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPenaltyType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('college_penalties', function (Blueprint $table) {
            // $table->tinyInteger('days_extension')->default(0)->after('active');
            $table->enum('type', ['percentage', 'amount'])->default('percentage')->after('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('college_penalties', function (Blueprint $table) {
            // $table->dropColumn("days_extension");
            $table->dropColumn("type");
        });
    }
}
