<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class   LasActivitySessions extends Migration
{
    public function up()
    {
        Schema::table('user_sessions', function (Blueprint $table) {
            $table->timestamp('last_activity')->nullable();
        });
    }

    public function down()
    {
        Schema::table('user_sessions', function (Blueprint $table) {
            $table->dropColumn('last_activity');
        });
    }
}
