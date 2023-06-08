<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNulleableDateLoteGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_lots_group', function (Blueprint $table) {
            $table->date('date_of_due')->nullable()->change();
            // $table->boolean("show_stock_establishment_box")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_lots_group', function (Blueprint $table) {
            // $table->dropColumn('show_stock_establishment_box');
            // $table->date('date_of_due')->nullable(false)->change();
        });
    }
}
