<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class IsVipZonesTables extends Migration
{
    public function up(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->boolean('is_vip')->default(false);
        });
    }

    public function down()
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->dropColumn('is_vip');
        });
    }
}
