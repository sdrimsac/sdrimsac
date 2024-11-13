<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//2024_10_09_1915234_add_points_value_document_item

class AddPointsValuePromotionDocumentItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotion_document_items', function (Blueprint $table) {
            $table->decimal('points_value', 10, 2)->default(0);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotion_document_items', function (Blueprint $table) {
            $table->dropColumn('points_value');
        });
    }
}