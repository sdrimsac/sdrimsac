<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UniqueCodeConfigurations extends Migration
{
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('unique_code_unit_types')->default(false);
        });
    }

    public function down()
    {
       Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('unique_code_unit_types');
        });
    }
}
