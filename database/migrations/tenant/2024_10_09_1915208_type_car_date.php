<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class TypeCarDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('tenant')->table('tipo_vehiculo')->insert([
            ['id' => 1, 'description' =>  'Camioneta'],
            ['id' => 2, 'description' =>  'Auto',],
            ['id' => 3, 'description' =>  'Moto Car',],
            ['id' => 4, 'description' =>  'Bajaj',],
            ['id' => 5, 'description' =>  'Moto',]
        ]);   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //  Schema::dropIfExists('payment_method_types');
        DB::connection('tenant')->table('tipo_vehivulo')->delete();
    }
}
