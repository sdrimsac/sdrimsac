<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReasonToAnulateCredit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_note_credits', function (Blueprint $table) {
            $table->text('reason_to_anulate_credit')->nullable();
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
            $table->dropColumn('reason_to_anulate_credit');
        });
    }
}
