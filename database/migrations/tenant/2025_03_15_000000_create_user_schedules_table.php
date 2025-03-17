<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSchedulesTable extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('name')->nullable()->comment('Nombre del horario');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('user_schedule_days', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_schedule_id');
            $table->tinyInteger('day_of_week')->comment('0: Domingo, 1: Lunes, 2: Martes, 3: Miércoles, 4: Jueves, 5: Viernes, 6: Sábado');
            $table->boolean('is_working_day')->default(true)->comment('Indica si es un día laborable');
            $table->timestamps();

            $table->foreign('user_schedule_id')->references('id')->on('user_schedules')->onDelete('cascade');
        });

        Schema::create('user_schedule_time_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_schedule_day_id');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('slot_duration')->default(60)->comment('Duración del slot en minutos');
            $table->integer('break_between_slots')->default(0)->comment('Tiempo de descanso entre slots en minutos');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('user_schedule_day_id')->references('id')->on('user_schedule_days')->onDelete('cascade');
        });

        Schema::create('user_schedule_exceptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->date('exception_date');
            $table->boolean('is_working_day')->default(false)->comment('Indica si es un día laborable (para marcar feriados o días especiales)');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('reason')->nullable()->comment('Motivo de la excepción');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('user_schedule_appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->comment('Usuario que atiende (estilista, médico, etc.)');
            $table->unsignedInteger('client_id')->nullable()->comment('Cliente o paciente');
            $table->date('appointment_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('duration')->comment('Duración en minutos');
            $table->string('status')->default('scheduled')->comment('scheduled, completed, cancelled, no_show');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('service_id')->nullable()->comment('Servicio relacionado');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('persons')->onDelete('set null');
        });
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_schedule_appointments');
        Schema::dropIfExists('user_schedule_exceptions');
        Schema::dropIfExists('user_schedule_time_slots');
        Schema::dropIfExists('user_schedule_days');
        Schema::dropIfExists('user_schedules');
    }
} 