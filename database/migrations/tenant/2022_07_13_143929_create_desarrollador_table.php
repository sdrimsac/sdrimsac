<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesarrolladorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desarrollador', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->default('SDRIMSAC SOLUTIONS');
        });
        DB::table('desarrollador')->insert([
            ['name' => 'SDRIMSAC SOLUTIONS'],
         ]);

    }

    public function down()
    {
        Schema::dropIfExists('desarrollador');
    }
}
