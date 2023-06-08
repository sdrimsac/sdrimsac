<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSendMessageActivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean("send_whatsapp_activity")->default(0);
            $table->boolean("pin_orden_delete")->default(0);
            $table->string("number_activity",11)->nullable();
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
            $table->dropColumn('send_whatsapp_activity');
            $table->dropColumn('pin_orden_delete');
            $table->dropColumn('number_activity');
        });
    }
}
