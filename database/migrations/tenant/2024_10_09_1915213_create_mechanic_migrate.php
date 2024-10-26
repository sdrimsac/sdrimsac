<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateMechanicMigrate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('tenant')->table('services')->insert([
            ['description' =>  'Motor'],
            ['description' =>  'Frenos',],
            ['description' =>  'Transmision',],
            ['description' =>  'Sistema de Escape',],
            ['description' =>  'Suspension',],
            ['description' =>  'Sistema Electrico',],
            ['description' =>  'Neumaticos-Rotacion',],
            ['description' =>  'Sistema de Direccion',],
            ['description' =>  'Aire Acondicionado',],
            ['description' =>  'Sistema de Refrigeracion',]
        ]); 
        
        DB::connection('tenant')->table('services_details')->insert([
            ['service_id' => 1, 'name' => 'cambio de aceite y filtro de aceite'],
            ['service_id' => 1, 'name' => 'Revision y cambio de Correas(correa de distribucion, correa del alternador)'],
            ['service_id' => 1, 'name' => 'Sustitucion de bujias y bobinas de encendido'],
            ['service_id' => 1, 'name' => 'Limpieza de inyectores'],
            ['service_id' => 2, 'name' => 'Reemplazo de pastillas de freno'],
            ['service_id' => 2, 'name' => 'Rectificacion o cambio de discos de freno'],
            ['service_id' => 2, 'name' => 'Revision y purga del liquido de frenos'],
            ['service_id' => 2, 'name' => 'cambio de zapatas'],
            ['service_id' => 2, 'name' => 'Ajustes de frenos traseros (si son de tambor)'],
            ['service_id' => 3, 'name' => 'Cambio de fluido de transmision (manual o automatica)'],
            ['service_id' => 3, 'name' => 'Inspecion y ajuste del embrage'],
            ['service_id' => 3, 'name' => 'Revision de retenes y juntas'],
            ['service_id' => 4, 'name' => 'Revision del Catalizador'],
            ['service_id' => 4, 'name' => 'Inspeccion de tubos de escape y silenciadores'],
            ['service_id' => 4, 'name' => 'Reemplazo de sensores de oxigeno'],
            ['service_id' => 5, 'name' => 'Cambio de Amortiguadores'],
            ['service_id' => 5, 'name' => 'Revision y Cambio de muelles o resortes'],
            ['service_id' => 5, 'name' => 'Inspeccion de bujes y componentes de la suspencion'],
            ['service_id' => 6, 'name' => 'Revison y reemplazo de la bateria'],
            ['service_id' => 6, 'name' => 'Sustitucion de fusibles y reles'],
            ['service_id' => 6, 'name' => 'Inspeccion y ajuste del sistema de luces'],
            ['service_id' => 6, 'name' => 'Verificacion del alternador y motor de arranque'],
            ['service_id' => 7, 'name' => 'Rotacion de neumaticos'],
            ['service_id' => 7, 'name' => 'alineacion y balanceo de las ruedas'],
            ['service_id' => 7, 'name' => 'Revision y reparacion de pinchaduras'],
            ['service_id' => 7, 'name' => 'Medicion y ajuste de la presion de los neumaticos'],
            ['service_id' => 8, 'name' => 'Ajuste y alineacion de la direccion'],
            ['service_id' => 8, 'name' => 'Revision de fluidos de la direccion asistida'],
            ['service_id' => 8, 'name' => 'Verificacion de las Barras y rotulas de direccion'],
            ['service_id' => 9, 'name' => 'Recarga de gas refrigerante'],
            ['service_id' => 9, 'name' => 'Revision y cambio del filtro de aire acondicionado'],
            ['service_id' => 9, 'name' => 'Inspecion de compresor y evaporador'],
            ['service_id' => 9, 'name' => 'Verificacion de fugas en las lineas'],
            ['service_id' => 10, 'name' => 'Cambio de liquido refrigerante'],
            ['service_id' => 10, 'name' => 'Limpieza del radiador'],
            ['service_id' => 10, 'name' => 'Inspeccion y reemplazo de mangueras y termostato'],
            ['service_id' => 10, 'name' => 'Verificacion del ventilador del radiador'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection('tenant')->table('services')->delete();
        DB::connection('tenant')->table('services_details')->delete();
    }
}
