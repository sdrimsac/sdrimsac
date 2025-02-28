<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

//2024_12_27_150038_insert_info_whatspp_send_schedule

class InsertInfoWhatsappSendSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('message_send_schedule')->insert([
            ['send_day_at' => 25, 'active' => true],
            ['send_day_at' => 28, 'active' => true],
            ['send_day_at' => 30, 'active' => true],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('message_send_schedule')->whereIn('send_day_at', [25, 28, 30])->delete();
    }
}
