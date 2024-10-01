<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPromotionUnitType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_unit_types', function (Blueprint $table) {
            $table->boolean('has_promotion')->default(false);
            $table->decimal('qty_min', 10, 2)->default(0);
            $table->decimal('qty_max', 10, 2)->default(0);
            $table->decimal('qty_free', 10, 2)->default(0);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_unit_types', function (Blueprint $table) {
            $table->dropColumn('has_promotion');
            $table->dropColumn('qty_min');
            $table->dropColumn('qty_max');
            $table->dropColumn('qty_free');
        });
        
    }

    
}
