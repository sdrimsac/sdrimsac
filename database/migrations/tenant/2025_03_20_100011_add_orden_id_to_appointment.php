<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2025_03_20_100011_add_orden_id_to_appointment
class AddOrdenIdToAppointment extends Migration
{
    public function up()
    {
        Schema::table('user_schedule_appointments', function (Blueprint $table) {
            $table->unsignedInteger('orden_id')
                ->after('service_id')
                ->nullable();

            $table->foreign('orden_id')
                ->references('id')
                ->on('ordens')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('user_schedule_appointments', function (Blueprint $table) {
            $table->dropColumn('orden_id');
        });
    }
}
