<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtiquetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etiquetas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('cv_id');
            $table->unsignedInteger('cc_id');
            $table->string('compra')->nullable();
            $table->string('venta')->nullable();
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('cv_id')->references('id')->on('codigos');
            $table->foreign('cc_id')->references('id')->on('codigos');
        });
    }

    public function down()
    {
        Schema::dropIfExists('etiquetas');
    }
}
