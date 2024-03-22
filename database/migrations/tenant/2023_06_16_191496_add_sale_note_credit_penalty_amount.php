<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddSaleNoteCreditPenaltyAmount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_note_credits', function (Blueprint $table) {
            $table->decimal('penalty_amount_by_day', 12, 2)->default(0);
        });
        
        Schema::table('payments', function (Blueprint $table) {
            $table->decimal('penalty_amount', 12, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_note_credits', function (Blueprint $table) {
            $table->dropColumn('penalty_amount_by_day');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('penalty_amount');
        });
        
    }
}
