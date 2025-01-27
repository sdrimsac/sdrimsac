<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertDateParent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('tenant')->table('person_parient')->insert([
            ['id' => 1, 'description' =>  'MAMA'],
            ['id' => 2, 'description' =>  'PAPA',],
            ['id' => 3, 'description' =>  'TIO',],
            ['id' => 4, 'description' =>  'TIA',],
            ['id' => 5, 'description' =>  'ABUELO',],
            ['id' => 6, 'description' =>  'ABUELA',],
            ['id' => 7, 'description' =>  'ESPOSA',],
            ['id' => 8, 'description' =>  'ESPOSO',],
            ['id' => 9, 'description' =>  'HERMANO',],
            ['id' => 10, 'description' =>  'HERMANA',],
            ['id' => 11, 'description' =>  'HIJO',],
            ['id' => 12, 'description' =>  'HIJA',],
            ['id' => 13, 'description' =>  'SOBRINO',],
            ['id' => 14, 'description' =>  'SOBRINA',],
            ['id' => 15, 'description' =>  'PRIMO',],
            ['id' => 16, 'description' =>  'PRIMA',],
            ['id' => 17, 'description' =>  'CUÑADO',],
            ['id' => 18, 'description' =>  'CUÑADA',],
            ['id' => 19, 'description' =>  'SUEGRO',],
            ['id' => 20, 'description' =>  'SUEGRA',],
            ['id' => 21, 'description' =>  'NUERA',],
            ['id' => 22, 'description' =>  'YERNO',],
            ['id' => 23, 'description' =>  'NIETO',],
            ['id' => 24, 'description' =>  'NIETA',],
            ['id' => 25, 'description' =>  'OTRO',]
        ]);   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection('tenant')->table('person_parient')->delete();
    }
}
