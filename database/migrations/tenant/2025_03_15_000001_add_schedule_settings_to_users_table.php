<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScheduleSettingsToUsersTable extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('has_schedule')->default(false)->after('locked')->comment('Indica si el usuario tiene horario de atención');
            $table->integer('default_appointment_duration')->default(60)->after('has_schedule')->comment('Duración predeterminada de citas en minutos');
            $table->integer('max_daily_appointments')->nullable()->after('default_appointment_duration')->comment('Número máximo de citas diarias');
            $table->json('schedule_settings')->nullable()->after('max_daily_appointments')->comment('Configuraciones adicionales del horario');
        });
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('has_schedule');
            $table->dropColumn('default_appointment_duration');
            $table->dropColumn('max_daily_appointments');
            $table->dropColumn('schedule_settings');
        });
    }
} 