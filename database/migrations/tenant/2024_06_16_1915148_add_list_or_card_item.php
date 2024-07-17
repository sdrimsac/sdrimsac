<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddListOrCardItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('list_or_card')->default(false);
            $table->boolean('lotgroup_list_or_card')->default(false);
            $table->boolean('listprice_list_or_card')->default(false);
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
            $table->dropColumn('list_or_card');
            $table->dropColumn('lotgroup_list_or_card');
            $table->dropColumn('listprice_list_or_card');
        });
    }
}
