<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertPrincipalCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('tenant')->table('principal_categories')->insert([
            [
                "name" => "ANALISIS CLINICO Y LABORATORIO",
                "identifier" => "13.34.21"
            ],
            [
                "name" => "CIRUGIA",
                "identifier" => "13.34.15"
            ],
            [
                "name" => "DIAGNOSTICO POR IMAGEN",
                "identifier" => "13.34.24"
            ],
            [
                "name" => "SERVICIO DE EMERGENCIA",
                "identifier" => "13.34.14"
            ],
            [
                "name" => "ATENCION DENTAL",
                "identifier" => "13.34.12"
            ],
            [
                "name" => "EXAMEN PSICOLOGICO",
                "identifier" => "13.34.13"
            ],
            [
                "name" => "CARNET Y/O TARJETA ATENCION",
                "identifier" => "13.24.16"
            ],
            [
                "name" => "CERTIFICADO MEDICO CML",
                "identifier" => "13.24.14"
            ],
            [
                "name" => "ATENCION MEDICA (CONSULTA)",
                "identifier" => "13.34.11"
            ],
            [
                "name" => "OTROS TRASLADOS DE CADAVER",
                "identifier" => "13.24.199"
            ],
            [
                "name" => "HOSPITALIZACION",
                "identifier" => "13.34.16"
            ],
            [
                "name" => "MEDICINA REHABILITACIÓN",
                "identifier" => "13.34.31"
            ],
            [
                "name" => "ELECTROCARDIOGRAMA",
                "identifier" => "13.34.23"
            ],
            [
                "name" => "EXHUMACIÓN DE CADÁVER",
                "identifier" => "13.34.199"
            ],
            [
                "name" => "TOPICO",
                "identifier" => "13.34.17"
            ],
            [
                "name" => "SERVICIO DE AMBULANCIA",
                "identifier" => "13.32.14"
            ],
            [
                "name" => "OTROS SERVICIOS DE SALUD",
                "identifier" => "13.34.399"
            ],

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection('tenant')->table('principal_categories')->delete();
    }
}
