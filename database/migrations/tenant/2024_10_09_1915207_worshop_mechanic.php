<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WorshopMechanic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_vehiculo', function (Blueprint $table) {

            $table->increments('id');
            $table->string('description');
            $table->timestamps();

        });
        Schema::create('vehiculos', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('tipo_vehiculo_id')->nullable();
            $table->string('marca');
            $table->string('modelo');
            $table->string('anio_fabricacion');
            $table->string('placa');
            $table->string('kilometraje');
            $table->boolean('active')->default=true;
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('persons');
            $table->foreign('tipo_vehiculo_id')->references('id')->on('tipo_vehiculo');
            
        });
        Schema::create('personal', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('number');
            $table->string('telephone')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('establishment_id')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
        Schema::create('historial', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('vehiculo_id');
            $table->unsignedInteger('sale_note_id')->nullable();
            $table->unsignedInteger('document_id')->nullable();
            $table->unsignedInteger('personal_id');
            $table->unsignedInteger('establishment_id');
            $table->unsignedInteger('item_werehouse_id');
            $table->string('observacion');
            $table->timestamps();
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos');
            $table->foreign('sale_note_id')->references('id')->on('sale_notes');
            $table->foreign('document_id')->references('id')->on('documents');
            $table->foreign('establishment_id')->references('id')->on('establishments');
            $table->foreign('item_werehouse_id')->references('id')->on('item_warehouse');
            $table->foreign('personal_id')->references('id')->on('personal');

        });
        Schema::create('historial_item', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('item_id');
            $table->decimal('cantidad');
            $table->decimal('price');
            $table->timestamps();
            $table->foreign('item_id')->references('id')->on('items');

        });  
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('vehiculo');
        Schema::dropIfExists('historial');
        Schema::dropIfExists('historial_item');
        Schema::dropIfExists('tipo_vehiculo');
    }
}