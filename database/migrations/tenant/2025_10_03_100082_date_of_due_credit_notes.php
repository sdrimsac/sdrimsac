<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DateOfDueCreditNotes extends Migration
{
    public function up()
    {
        Schema::table('sale_note_payments', function (Blueprint $table) {
            $table->datetime('date_time_issue')->nullable();
        });
    }

    public function down()
    {
        Schema::table('sale_note_payments', function (Blueprint $table) {
            $table->dropColumn('date_time_issue');
        });
    }
}
