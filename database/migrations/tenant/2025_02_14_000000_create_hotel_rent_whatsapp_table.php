<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelRentWhatsappTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_rent_whatsapp', function (Blueprint $table) {
            $table->id();
            $table->string('type')->comment('Tipo de mensaje: antes o después del vencimiento');
            $table->integer('message_order')->comment('Orden del mensaje (1°, 2°, 3° mensaje)');
            $table->text('content')->nullable()->comment('Contenido del mensaje');
            $table->integer('days')->default(0)->comment('Días de anticipación o después del vencimiento');
            $table->time('send_time')->nullable()->comment('Hora programada para envío');
            $table->boolean('active')->default(true)->comment('Estado del mensaje');
            $table->timestamps();
            
            // Índices para mejorar el rendimiento de las consultas
            $table->index(['type', 'message_order']);
            $table->index('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_rent_whatsapp');
    }
} 