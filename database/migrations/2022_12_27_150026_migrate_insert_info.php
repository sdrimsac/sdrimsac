<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MigrateInsertInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('business')->insert([
            ['id' => 1, 'description' =>  'RESTAURANT'],
            ['id' => 2, 'description' =>  'HOTEL',],
            ['id' => 3, 'description' =>  'RESTOBAR',],
            ['id' => 4, 'description' =>  'ABARROTES',],
            ['id' => 5, 'description' =>  'FERRETERIA',],
            ['id' => 6, 'description' =>  'BOTICA',],
            ['id' => 7, 'description' =>  'DISTRIBUIDORA',],
            ['id' => 8, 'description' =>  'CREDITO',],
            ['id' => 9, 'description' =>  'INTERNET',],
            ['id' => 10, 'description' =>  'COLEGIO',],
            ['id' => 11, 'description' =>  'MADERA',],
            ['id' => 12, 'description' =>  'PEAJE',],
            ['id' => 13, 'description' =>  'MECANICA',],
            ['id' => 14, 'description' =>  'HOSPITAL',],
            ['id' => 15, 'description' =>  'BILLAR',]
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
        DB::table('business')->delete();
    }
}
