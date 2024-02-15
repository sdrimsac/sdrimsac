<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceItemColorsSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_colors_sizes', function (Blueprint $table) {
            $table->decimal('price', 12, 2)->default(0)->after('stock');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            Schema::table('item_colors_sizes', function (Blueprint $table) {
                    $table->dropColumn('price');
            });

     
    }
}
