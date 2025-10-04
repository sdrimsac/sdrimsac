<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ConfCompanySaleNoteCredit extends Migration
{
    public function up()
    {
        Schema::table('conf_establishment', function (Blueprint $table) {

            $table->boolean('sale_credit_notes')->default(false);
        });
    }

    public function down()
    {
        Schema::table('conf_establishment', function (Blueprint $table) {
            $table->dropColumn('sale_credit_notes');
        });
    }
}