<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddAreaIdAndUserIdToOrderItemDetailsTable extends Migration
{
    public function up(): void
    {
        Schema::table('order_item_details', function (Blueprint $table) {

            if (!Schema::hasColumn('order_item_details', 'area_id')) {
                $table->unsignedInteger('area_id')->nullable()->after('item_id');
                $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
            }

            if (!Schema::hasColumn('order_item_details', 'user_id')) {
                // 🔹 cambiar de unsignedBigInteger a unsignedInteger
                $table->unsignedInteger('user_id')->nullable()->after('area_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('order_item_details', function (Blueprint $table) {
            if (Schema::hasColumn('order_item_details', 'area_id')) {
                $table->dropForeign(['area_id']);
                $table->dropColumn('area_id');
            }

            if (Schema::hasColumn('order_item_details', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
}
