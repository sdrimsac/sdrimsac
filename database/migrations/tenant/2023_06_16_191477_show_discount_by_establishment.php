<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ShowDiscountByEstablishment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conf_establishment', function (Blueprint $table) {
            $table->boolean('show_discounts_payment')->default(true);
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
                    $table->dropColumn('show_discounts_payment');
            });

     
    }
}
