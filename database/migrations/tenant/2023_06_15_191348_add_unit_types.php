<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddUnitTypes extends Migration
{

    public function up()
    {

        DB::connection('tenant')->table('cat_unit_types')->upsert([
            // ['id' => 1, 'description' => 'BARRA',  'active' => 1],
            ["id" => "4A", "description" => "BOBINAS", "active" => 0],
            ["id" => "BJ", "active" => 0, "description" => "BALDE"],
            ["id" => "BLL", "active" => 1, "description" =>    "BARRILES"],
            ["id" => "BG", "active" => 1, "description" =>    "BOLSA"],
            ["id" => "BO", "active" => 1, "description" =>    "BOTELLAS"],
            ["id" => "CT", "active" => 1, "description" =>    "CARTONES"],
            ["id" => "CMK", "active" => 0, "description" =>    "CENTIMETRO CUADRADO"],
            ["id" => "CMQ", "active" => 0, "description" =>    "CENTIMETRO CUBICO"],
            ["id" => "CMT", "active" => 0, "description" =>    "CENTIMETRO LINEAL"],
            ["id" => "CEN", "active" => 0, "description" =>    "CIENTO DE UNIDADES"],
            ["id" => "CY", "active" => 0, "description" =>    "CILINDRO"],
            ["id" => "CJ", "active" => 0, "description" =>    "CONOS"],
            ["id" => "DZN", "active" => 0, "description" =>    "DOCENA"],
            ["id" => "BE", "active" => 0, "description" =>    "FARDO"],
            ["id" => "GRO", "active" => 0, "description" =>    "GRUESA"],
            ["id" => "HLT", "active" => 0, "description" =>    "HECTOLITRO"],
            ["id" => "LEF", "active" => 0, "description" =>    "HOJA"],
            ["id" => "SET", "active" => 0, "description" =>    "JUEGO"],
            ["id" => "KTM", "active" => 0, "description" =>    "KILOMETRO"],
            ["id" => "KWH", "active" => 1, "description" =>    "KILOVATIO HORA"],
            ["id" => "KT", "active" => 0, "description" =>    "KIT"],
            ["id" => "CA", "active" => 1, "description" => "LATAS"],
            ["id" => "LBR", "active" => 1, "description" =>    "LIBRAS"],
            ["id" => "MWH", "active" => 0, "description" =>    "MEGAWATT HORA"],
            ["id" => "MTK", "active" => 0, "description" =>    "METRO CUADRADO"],
            ["id" => "MTQ", "active" => 0, "description" =>    "METRO CUBICO"],
            ["id" => "MGM", "active" => 1, "description" =>    "MILIGRAMOS"],
            ["id" => "MLT", "active" => 1, "description" =>    "MILILITRO"],
            ["id" => "MMT", "active" => 1, "description" =>    "MILIMETRO"],
            ["id" => "MMK", "active" => 1, "description" =>    "MILIMETRO CUADRADO"],
            ["id" => "MMQ", "active" => 1, "description" =>    "MILIMETRO CUBICO"],
            ["id" => "MLL", "active" => 1, "description" =>    "MILLARES"],
            ["id" => "UM", "active" => 1, "description" =>    "MILLON DE UNIDADES"],
            ["id" => "ONZ", "active" => 1, "description" =>    "ONZAS"],
            ["id" => "PF", "active" => 1, "description" =>    "PALETAS"],
            ["id" => "PK", "active" => 1, "description" =>    "PAQUETE"],
            ["id" => "PR", "active" => 0, "description" =>    "PAR"],
            ["id" => "FTK", "active" => 0, "description" =>    "PIES CUADRADOS"],
            ["id" => "FTQ", "active" => 0, "description" =>    "PIES CUBICOS"],
            ["id" => "C62", "active" => 1, "description" =>    "PIEZAS"],
            ["id" => "PG", "active" => 1, "description" =>    "PLACAS"],
            ["id" => "ST", "active" => 1, "description" =>    "PLIEGO"],
            ["id" => "RM", "active" => 0, "description" =>    "RESMA"],
            ["id" => "DR", "active" => 0, "description" =>    "TAMBOR"],
            ["id" => "STN", "active" => 0, "description" =>    "TONELADA CORTA"],
            ["id" => "LTN", "active" => 0, "description" =>    "TONELADA LARGA"],
            ["id" => "TNE", "active" => 0, "description" =>    "TONELADAS"],
            ["id" => "TU", "active" => 1, "description" =>    "TUBOS"],
            ["id" => "YDK", "active" => 0, "description" =>    "YARDA CUADRADA"],

        ], ['id']);
        // Schema::table('items', function (Blueprint $table) {
        //     $table->string('max_quantity_description')->nullable()
        //         ->after('max_quantity');
        // });

    }


    public function down()
    {


        // Schema::table('items', function (Blueprint $table) {
        //     $table->dropColumn('max_quantity_description');
        // });
    }
}
