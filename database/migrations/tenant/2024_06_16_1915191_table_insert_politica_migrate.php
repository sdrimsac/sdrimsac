<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class TableInsertPoliticaMigrate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('tenant')->table('categoria_madera')->insert([
            ['id' => 1, 'description' =>  'Comercial'],
            ['id' => 2, 'description' =>  'Especial',]
        ]);
        DB::connection('tenant')->table('categoria_madera_medida_alto')->insert([
            ['id' => 1, 'categoria_madera_id' => 1, 'alto' => 6],
            ['id' => 2, 'categoria_madera_id' => 1, 'alto' => 7],
            ['id' => 3, 'categoria_madera_id' => 1, 'alto' => 8],
            ['id' => 4, 'categoria_madera_id' => 1, 'alto' => 9],
            ['id' => 5, 'categoria_madera_id' => 1, 'alto' => 10],
            ['id' => 6, 'categoria_madera_id' => 2, 'alto' => 11],
            ['id' => 7, 'categoria_madera_id' => 2, 'alto' => 12],
            ['id' => 8, 'categoria_madera_id' => 2, 'alto' => 13],
            ['id' => 9, 'categoria_madera_id' => 2, 'alto' => 14],
            ['id' => 10, 'categoria_madera_id' => 2, 'alto' => 15],
            ['id' => 11, 'categoria_madera_id' => 2, 'alto' => 16],
            ['id' => 12, 'categoria_madera_id' => 2, 'alto' => 17],
            ['id' => 13, 'categoria_madera_id' => 2, 'alto' => 18],
            ['id' => 14, 'categoria_madera_id' => 2, 'alto' => 19],
            ['id' => 15, 'categoria_madera_id' => 2, 'alto' => 20],
            ['id' => 16, 'categoria_madera_id' => 2, 'alto' => 21],
            ['id' => 17, 'categoria_madera_id' => 2, 'alto' => 22],
            ['id' => 18, 'categoria_madera_id' => 2, 'alto' => 23],
            ['id' => 19, 'categoria_madera_id' => 2, 'alto' => 24],
            ['id' => 20, 'categoria_madera_id' => 2, 'alto' => 25],
            ['id' => 21, 'categoria_madera_id' => 2, 'alto' => 26],
            ['id' => 22, 'categoria_madera_id' => 2, 'alto' => 27],
            ['id' => 23, 'categoria_madera_id' => 2, 'alto' => 28],
            ['id' => 24, 'categoria_madera_id' => 2, 'alto' => 29],
            ['id' => 25, 'categoria_madera_id' => 2, 'alto' => 30]

        ]);
        DB::connection('tenant')->table('categoria_madera_medida_ancho')->insert([
            ['id' => 1, 'categoria_madera_id' => 2, 'ancho' => 1],
            ['id' => 2, 'categoria_madera_id' => 2, 'ancho' => 2],
            ['id' => 3, 'categoria_madera_id' => 2, 'ancho' => 3],
            ['id' => 4, 'categoria_madera_id' => 2, 'ancho' => 4],
            ['id' => 5, 'categoria_madera_id' => 2, 'ancho' => 5],
            ['id' => 6, 'categoria_madera_id' => 2, 'ancho' => 6],
            ['id' => 7, 'categoria_madera_id' => 2, 'ancho' => 7],
            ['id' => 8, 'categoria_madera_id' => 2, 'ancho' => 8],
            ['id' => 9, 'categoria_madera_id' => 2, 'ancho' => 9],
            ['id' => 10, 'categoria_madera_id' => 2, 'ancho' => 10],
            ['id' => 11, 'categoria_madera_id' => 2, 'ancho' => 11],
            ['id' => 12, 'categoria_madera_id' => 2, 'ancho' => 12],
            ['id' => 12, 'categoria_madera_id' => 2, 'ancho' => 13],
            ['id' => 14, 'categoria_madera_id' => 2, 'ancho' => 14],
            ['id' => 15, 'categoria_madera_id' => 2, 'ancho' => 15],
            ['id' => 16, 'categoria_madera_id' => 2, 'ancho' => 16],
            ['id' => 17, 'categoria_madera_id' => 2, 'ancho' => 17],
            ['id' => 18, 'categoria_madera_id' => 2, 'ancho' => 18],
            ['id' => 19, 'categoria_madera_id' => 2, 'ancho' => 19],
            ['id' => 20, 'categoria_madera_id' => 2, 'ancho' => 20],
            ['id' => 21, 'categoria_madera_id' => 2, 'ancho' => 21],
            ['id' => 22, 'categoria_madera_id' => 2, 'ancho' => 22],
            ['id' => 23, 'categoria_madera_id' => 2, 'ancho' => 23],
            ['id' => 24, 'categoria_madera_id' => 2, 'ancho' => 24],
            ['id' => 25, 'categoria_madera_id' => 2, 'ancho' => 25],
            ['id' => 26, 'categoria_madera_id' => 2, 'ancho' => 26],
            ['id' => 27, 'categoria_madera_id' => 2, 'ancho' => 27],
            ['id' => 28, 'categoria_madera_id' => 2, 'ancho' => 28],
            ['id' => 29, 'categoria_madera_id' => 2, 'ancho' => 29],
            ['id' => 30, 'categoria_madera_id' => 2, 'ancho' => 30],

            ['id' => 31, 'categoria_madera_id' => 1, 'ancho' => 31],
            ['id' => 32, 'categoria_madera_id' => 1, 'ancho' => 32],
            ['id' => 33, 'categoria_madera_id' => 1, 'ancho' => 33],
            ['id' => 34, 'categoria_madera_id' => 1, 'ancho' => 34],
            ['id' => 35, 'categoria_madera_id' => 1, 'ancho' => 35],
            ['id' => 36, 'categoria_madera_id' => 1, 'ancho' => 36],
            ['id' => 37, 'categoria_madera_id' => 1, 'ancho' => 37],
            ['id' => 38, 'categoria_madera_id' => 1, 'ancho' => 38],
            ['id' => 39, 'categoria_madera_id' => 1, 'ancho' => 39],
            ['id' => 40, 'categoria_madera_id' => 1, 'ancho' => 40],

            ['id' => 41, 'categoria_madera_id' => 1, 'ancho' => 2],
            ['id' => 42, 'categoria_madera_id' => 1, 'ancho' => 3],
            ['id' => 43, 'categoria_madera_id' => 1, 'ancho' => 4],
            ['id' => 44, 'categoria_madera_id' => 1, 'ancho' => 5],
            ['id' => 45, 'categoria_madera_id' => 1, 'ancho' => 6],
            ['id' => 46, 'categoria_madera_id' => 1, 'ancho' => 7],
            ['id' => 47, 'categoria_madera_id' => 1, 'ancho' => 8],
            ['id' => 48, 'categoria_madera_id' => 1, 'ancho' => 9],
            ['id' => 49, 'categoria_madera_id' => 1, 'ancho' => 10],
            ['id' => 50, 'categoria_madera_id' => 1, 'ancho' => 11],
            ['id' => 51, 'categoria_madera_id' => 1, 'ancho' => 12],
            ['id' => 52, 'categoria_madera_id' => 1, 'ancho' => 13],
            ['id' => 53, 'categoria_madera_id' => 1, 'ancho' => 14],


        ]);
        DB::connection('tenant')->table('categoria_madera_medida_grosor')->insert([

            ['id' => 1, 'categoria_madera_id' => 2, 'grosor' => 1.5],

            ['id' => 2, 'categoria_madera_id' => 2, 'grosor' => 2],


            ['id' => 3, 'categoria_madera_id' => 2, 'grosor' => 3],

            ['id' => 4, 'categoria_madera_id' => 2, 'grosor' => 4],


            ['id' => 5, 'categoria_madera_id' => 1, 'grosor' => 1],

            ['id' => 6, 'categoria_madera_id' => 1, 'grosor' => 1.5],

            ['id' => 7, 'categoria_madera_id' => 1, 'grosor' => 2],

            ['id' => 8, 'categoria_madera_id' => 1, 'grosor' => 3],

            ['id' => 9, 'categoria_madera_id' => 1, 'grosor' => 4],

            ['id' => 10, 'categoria_madera_id' => 1, 'grosor' => 5],

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
        DB::connection('tenant')->table('categoria_madera')->delete();
        DB::connection('tenant')->table('categoria_madera_medida_alto')->delete();
        DB::connection('tenant')->table('categoria_madera_medida_ancho')->delete();
        DB::connection('tenant')->table('categoria_madera_medida_grosor')->delete();
    }
}
