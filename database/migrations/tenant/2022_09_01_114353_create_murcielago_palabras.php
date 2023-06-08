<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMurcielagoPalabras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('murcielago_palabras', function (Blueprint $table) {
            $table->id();
            $table->string("palabra", 255);
            $table->string("indice", 15);
        });
    }

    public function down()
    {
        Schema::dropIfExists('murcielago_palabras');
    }
}
