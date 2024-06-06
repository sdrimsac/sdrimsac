<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WhatsappInLogin extends Migration
{


    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->unsignedInteger('whatsapp_in_login')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('whatsapp_in_login');
        });
    }
}
