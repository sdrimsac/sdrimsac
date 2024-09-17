<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableMadereraCategoria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria_madera', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
        });
        Schema::create('categoria_madera_medida_alto', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('alto');
            $table->unsignedInteger("categoria_madera_id");
            $table->timestamps();
            $table->foreign('categoria_madera_id')->references('id')->on('categoria_madera');
        });
        Schema::create('categoria_madera_medida_ancho', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('ancho');
            $table->unsignedInteger("categoria_madera_id");
            $table->timestamps();
            $table->foreign('categoria_madera_id')->references('id')->on('categoria_madera');
        });
        Schema::create('categoria_madera_medida_grosor', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('grosor');
            $table->unsignedInteger("categoria_madera_id"); 
            $table->timestamps();
            $table->foreign('categoria_madera_id')->references('id')->on('categoria_madera');
        });
        Schema::create('item_categoria_madera', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('categoria_madera_id');
            $table->decimal('precio');
            $table->timestamps();
            $table->foreign('categoria_madera_id')->references('id')->on('categoria_madera');
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
        Schema::dropIfExists('categoria_madera');
        Schema::dropIfExists('categoria_madera_medida_ancho');
        Schema::dropIfExists('categoria_madera_medida_grosor');
        Schema::dropIfExists('categoria_madera_medida_alto');
        Schema::dropIfExists('item_categoria_madera');
    }
}
