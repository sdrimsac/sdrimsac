<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoteIdSeries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_lots', function (Blueprint $table) {
            $table->unsignedInteger('lote_id')->nullable()->after('state');
            $table->foreign('lote_id')->references('id')->on('item_lots_group');
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
        Schema::table('item_lots', function (Blueprint $table) {
            $table->dropForeign('item_lots_lote_id_foreign');
            $table->dropColumn('lote_id');
        });
    }
}
