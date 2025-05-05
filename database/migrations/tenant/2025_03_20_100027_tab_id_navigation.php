<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class   TabIdNavigation extends Migration
{
    public function up()
    {
        Schema::table('user_sessions', function (Blueprint $table) {
            $table->string('tab_id')->nullable()->after('session_id');
        });    
    }

    public function down()
    {
        Schema::table('user_sessions', function (Blueprint $table) {
            $table->dropColumn('tab_id');
        });
    }
}
