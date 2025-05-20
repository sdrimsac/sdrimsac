<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class  PolicyPriceUnit extends Migration
{
    public function up()
    {
        Schema::table('item_unit_types', function (Blueprint $table) {
            $table->string('unique_code')->nullable();
        });
    }

    public function down()
    {
       Schema::table('item_unit_types', function (Blueprint $table) {
            $table->dropColumn('unique_code');
        });
    }
}
