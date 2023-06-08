<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPosDirectSale extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conf_establishment', function (Blueprint $table) {
            $table->boolean("pos_quick_sale")->after('direct_sale')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conf_establishment', function (Blueprint $table) {
            $table->dropColumn('pos_quick_sale');
        });
    }
}
