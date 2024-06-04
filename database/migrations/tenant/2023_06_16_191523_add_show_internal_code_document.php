<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShowInternalCodeDocument extends Migration
{


    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->unsignedInteger('show_internal_code_ticket')->nullable();
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
            $table->dropColumn('show_internal_code_ticket');
        });
    }
}
