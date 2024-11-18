<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//2024_10_09_1915239_limites_changes_promotion_document



class LimitesChangesPromotionDocument extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotion_documents', function (Blueprint $table) {
            $table->integer('limit_changes')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotion_documents', function (Blueprint $table) {
            $table->dropColumn('limit_changes');
        });
    }
}
