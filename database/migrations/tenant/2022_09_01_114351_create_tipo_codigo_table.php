<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoCodigoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codigos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description')->nullable();
        });

        DB::table('codigos')->insert([
            ['description' => 'Cod. murciélago'],
            ['description' => 'Normal'],
            ['description' => 'Vacío'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('codigos');
    }
}
