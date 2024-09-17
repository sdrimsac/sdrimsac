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
            ['id' => 19, 'categoria_madera_id' => 2, 'alto' => 24]
        ]);
        DB::connection('tenant')->table('categoria_madera_medida_ancho')->insert([
            ['id' => 1, 'categoria_madera_id' => 2, 'ancho' => 2],
            ['id' => 2, 'categoria_madera_id' => 2, 'ancho' => 3],
            ['id' => 3, 'categoria_madera_id' => 2, 'ancho' => 4],
            ['id' => 4, 'categoria_madera_id' => 2, 'ancho' => 5],
            ['id' => 5, 'categoria_madera_id' => 2, 'ancho' => 6],
            ['id' => 6, 'categoria_madera_id' => 2, 'ancho' => 7],
            ['id' => 7, 'categoria_madera_id' => 2, 'ancho' => 8],
            ['id' => 8, 'categoria_madera_id' => 2, 'ancho' => 9],
            ['id' => 9, 'categoria_madera_id' => 2, 'ancho' => 10],
            ['id' => 10, 'categoria_madera_id' => 2, 'ancho' => 11],
            ['id' => 11, 'categoria_madera_id' => 2, 'ancho' => 12],
            ['id' => 12, 'categoria_madera_id' => 2, 'ancho' => 13],
            ['id' => 13, 'categoria_madera_id' => 2, 'ancho' => 14],

            ['id' => 14, 'categoria_madera_id' => 1, 'ancho' => 2],
            ['id' => 15, 'categoria_madera_id' => 1, 'ancho' => 3],
            ['id' => 16, 'categoria_madera_id' => 1, 'ancho' => 4],
            ['id' => 17, 'categoria_madera_id' => 1, 'ancho' => 5],
            ['id' => 18, 'categoria_madera_id' => 1, 'ancho' => 6],
            ['id' => 19, 'categoria_madera_id' => 1, 'ancho' => 7],
            ['id' => 20, 'categoria_madera_id' => 1, 'ancho' => 8],
            ['id' => 21, 'categoria_madera_id' => 1, 'ancho' => 9],
            ['id' => 22, 'categoria_madera_id' => 1, 'ancho' => 10],
            ['id' => 23, 'categoria_madera_id' => 1, 'ancho' => 11],
            ['id' => 24, 'categoria_madera_id' => 1, 'ancho' => 12],
            ['id' => 25, 'categoria_madera_id' => 1, 'ancho' => 13],
            ['id' => 26, 'categoria_madera_id' => 1, 'ancho' => 14],


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
