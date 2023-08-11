<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersToConsignment extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consignments', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('user_liquidated_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('user_liquidated_id')->references('id')->on('users');
        });

    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consignments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['user_liquidated_id']);
            $table->dropColumn('user_id');
            $table->dropColumn('user_liquidated_id');

        });
     
    }
}
