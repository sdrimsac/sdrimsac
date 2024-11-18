<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//2024_10_09_1915240_add_user_id_inventory_kardex



class AddUserIdInventoryKardex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_kardex', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_kardex', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
