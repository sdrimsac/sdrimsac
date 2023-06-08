<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatussOrdenTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     
        // DB::table('status_orden')->insert([
        //     ['id' => 1, 'description' => 'Solicitado', 'active' => 1],
        //     ['id' => 2, 'description' => 'Preparando', 'active' => 1],
        //     ['id' => 3, 'description' => 'Listo', 'active' => 1],
        //     ['id' => 4, 'description' => 'Atendido', 'active' => 1],
        //     ['id' => 5, 'description' => 'Cancelado', 'active' => 1],
        // ]);
        // DB::table('status_table')->insert([
        //     ['id' => 1, 'description' => 'Libre', 'active' => 1],
        //     ['id' => 2, 'description' => 'Ocupado', 'active' => 1],
        //     ['id' => 3, 'description' => 'En mantenimiento', 'active' => 1],

        // ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuss_orden_tables');
    }
}
