<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
//2024_10_09_1915284_add_code_item_color_sizes
class AddCodeItemColorSizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_colors_sizes', function (Blueprint $table) {
            $table->string('code')->nullable()->index();
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
            $table->dropColumn('code');
        });
    }
}
