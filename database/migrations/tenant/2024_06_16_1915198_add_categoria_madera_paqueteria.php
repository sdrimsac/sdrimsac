<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddCategoriaMaderaPaqueteria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('tenant')
            ->table('categoria_madera')
            ->insert([
                [
                    'id' => 3,
                    'description' => 'Paqueteria', 'sum_totals' => true
                ],
            ]);

        DB::connection('tenant')
            ->table('categoria_madera_medida_grosor')
            ->insert([
                ['grosor' => 6, 'categoria_madera_id' => 3],

            ]);

        DB::connection('tenant')
            ->table('categoria_madera_medida_ancho')
            ->insert([
                ['ancho' => 6, 'categoria_madera_id' => 3]
            ]);
        DB::connection('tenant')
            ->table('categoria_madera_medida_alto')
            ->insert([
                ['alto' => 2, 'categoria_madera_id' => 3],
                ['alto' => 3, 'categoria_madera_id' => 3],
                ['alto' => 4, 'categoria_madera_id' => 3],
                ['alto' => 5, 'categoria_madera_id' => 3],
                ['alto' => 6, 'categoria_madera_id' => 3]
            ]);
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        DB::connection('tenant')
            ->table('categoria_madera_medida_grosor')
            ->where('categoria_madera_id', 3)
            ->delete();


        DB::connection('tenant')
            ->table('categoria_madera_medida_ancho')
            ->where('categoria_madera_id', 3)
            ->delete();

        DB::connection('tenant')
            ->table('categoria_madera_medida_alto')
            ->where('categoria_madera_id', 3)
            ->delete();

        DB::connection('tenant')
            ->table('categoria_madera')
            ->where('id', 3)
            ->delete();
    }
}
