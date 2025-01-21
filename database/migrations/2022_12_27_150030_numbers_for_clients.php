<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;


//2022_12_27_150030_numbers_for_clients
class NumbersForClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->string('number_communication')->nullable()->default('995764963');
            $table->string('number_payment')->nullable()->default('995764963');
            $table->decimal('pricing', 10, 2)->nullable()->default(20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('number_communication');
            $table->dropColumn('number_payment');
            $table->dropColumn('pricing');
        });
    }
}
