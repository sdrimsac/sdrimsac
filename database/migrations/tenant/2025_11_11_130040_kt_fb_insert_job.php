<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KtFbInsertJob extends Migration
{
    public function up()
    {
        DB::table('job_positions')->insert([
            ['name' => 'Cajero', 'sueldo_base' => 1250, 'factor_diario' => 45.00, 'estado' => true],
            ['name' => 'Mozo', 'sueldo_base' => 1100, 'factor_diario' => 40.00, 'estado' => true],
            ['name' => 'Administrador', 'sueldo_base' => 1400, 'factor_diario' => 50.00, 'estado' => true],
        ]);
    }

    public function down()
    {
        Schema::table('job_positions', function (Blueprint $table) {
            $table->whereIn('name', ['Cajero', 'Mozo', 'Administrador'])->delete();
        });
    }
}
