<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CashEndTurnAutomaticCashPrincipal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function ($table) {
            $table->unsignedInteger('turn_end')->nullable();
            $table->boolean('automatic_principal_cash')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configurations', function ($table) {
            $table->dropColumn('turn_end');
            $table->dropColumn('automatic_principal_cash');
        });
    }
}
