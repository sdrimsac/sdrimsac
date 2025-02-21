<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//2025_02_17_100003_add_android_config_establishment
class AddAndroidConfigEstablishment extends Migration
{
    public function up()
    {
        Schema::table('establishments', function (Blueprint $table) {
            $table->boolean('android_configuration')->default(false);
        });
    }

    public function down()
    {
        Schema::table('establishments', function (Blueprint $table) {
            $table->dropColumn('android_configuration');
        });
    }
} 