<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateSymbolsUnitTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = [
            ['id' => 'ZZ', 'active' => 1, 'symbol' => 'SERV', 'description' => 'SERVICIO'],
            ['id' => 'NIU', 'active' => 1, 'symbol' => 'UND', 'description' => 'UNIDAD'],
            ['id' => 'KGM', 'active' => 1, 'symbol' => 'KG', 'description' => 'KILO'],
            ['id' => 'LTR', 'active' => 1, 'symbol' => 'LT', 'description' => 'LITRO'],
            ['id' => 'BX', 'active' => 1, 'symbol' => 'CAJA', 'description' => 'CAJA'],
            ['id' => 'GLL', 'active' => 1, 'symbol' => 'GAL', 'description' => 'GALON'],
            ['id' => 'BJ', 'active' => 1, 'symbol' => 'BALDE', 'description' => 'BALDE'],
            ['id' => 'DZN', 'active' => 1, 'symbol' => 'DOC', 'description' => 'DOCENA'],
            ['id' => 'KT', 'active' => 1, 'symbol' => 'KIT', 'description' => 'KIT'],
            ['id' => 'MTR', 'active' => 1, 'symbol' => 'MT', 'description' => 'METRO'],
            ['id' => 'YRD', 'active' => 1, 'symbol' => 'YARD', 'description' => 'YARDA'],
            ['id' => 'TNE', 'active' => 1, 'symbol' => 'TON', 'description' => 'TONELADA'],
            ['id' => 'GRM', 'active' => 1, 'symbol' => 'GR', 'description' => 'GRAMOS'],
            ['id' => 'BO', 'active' => 1, 'symbol' => 'BOT', 'description' => 'BOTELLA'],
            ['id' => 'ONZ', 'active' => 1, 'symbol' => 'OZ', 'description' => 'ONZA'],
            ['id' => 'MLL', 'active' => 1, 'symbol' => 'MILLAR', 'description' => 'MILLAR'],
            ['id' => 'INH', 'active' => 1, 'symbol' => 'PULG', 'description' => 'PULGADA'],
            ['id' => 'FOT', 'active' => 1, 'symbol' => 'PIE', 'description' => 'PIE'],
            ['id' => 'PK', 'active' => 1, 'symbol' => 'PQ', 'description' => 'PAQUETE'],
            ['id' => 'C62', 'active' => 1, 'symbol' => 'PZ', 'description' => 'PIEZA'],
            ['id' => 'BLL', 'active' => 1, 'symbol' => 'BARRIL', 'description' => 'BARRIL'],
            ['id' => 'HUR', 'active' => 1, 'symbol' => 'HORA', 'description' => 'HORA'],
            ['id' => 'BG', 'active' => 1, 'symbol' => 'BOLSA', 'description' => 'BOLSA'],
            ['id' => 'CT', 'active' => 1, 'symbol' => 'CART', 'description' => 'CARTON'],
            ['id' => 'KWH', 'active' => 1, 'symbol' => 'KV', 'description' => 'KILOVATIO HORA'],
            ['id' => 'CA', 'active' => 1, 'symbol' => 'LATA', 'description' => 'LATA'],
            ['id' => 'LBR', 'active' => 1, 'symbol' => 'LIBRA', 'description' => 'LIBRA'],
            ['id' => 'MGM', 'active' => 1, 'symbol' => 'MILIGRAMO', 'description' => 'MILIGRAMO'],
            ['id' => 'MLT', 'active' => 1, 'symbol' => 'MILILITRO', 'description' => 'MILILITRO'],
            ['id' => 'MMT', 'active' => 1, 'symbol' => 'MILIMETRO', 'description' => 'MILIMETRO'],
            ['id' => 'MMK', 'active' => 1, 'symbol' => 'M', 'description' => 'MILIMETRO CUADRADO'],
            ['id' => 'MMQ', 'active' => 1, 'symbol' => 'M', 'description' => 'MILIMETRO CUBICO'],
            ['id' => 'PF', 'active' => 1, 'symbol' => 'PALETA', 'description' => 'PALETA'],
            ['id' => 'PG', 'active' => 1, 'symbol' => 'PLACA', 'description' => 'PLACA'],
            ['id' => 'ST', 'active' => 1, 'symbol' => 'PLIEGO', 'description' => 'PLIEGO'],
            ['id' => 'TU', 'active' => 1, 'symbol' => 'TUB', 'description' => 'TUBO'],
            ['id' => '4A', 'active' => 0, 'symbol' => 'BOB', 'description' => 'BOBINA'],
            ['id' => 'CMK', 'active' => 0, 'symbol' => 'CMK', 'description' => 'CENTIMETRO CUADRADO'],
            ['id' => 'CMQ', 'active' => 0, 'symbol' => 'CMQ', 'description' => 'CENTIMETRO CUBICO'],
            ['id' => 'CMT', 'active' => 0, 'symbol' => 'CMT', 'description' => 'CENTIMETRO LINEAL'],
            ['id' => 'CEN', 'active' => 0, 'symbol' => 'CENT', 'description' => 'CIENTO DE UNIDADES'],
            ['id' => 'CY', 'active' => 0, 'symbol' => 'CY', 'description' => 'CILINDRO'],
            ['id' => 'CJ', 'active' => 0, 'symbol' => 'CJ', 'description' => 'CONO'],
            ['id' => 'BE', 'active' => 0, 'symbol' => 'BE', 'description' => 'FARDO'],
            ['id' => 'GRO', 'active' => 0, 'symbol' => 'GRO', 'description' => 'GRUESA'],
            ['id' => 'HLT', 'active' => 0, 'symbol' => 'HLT', 'description' => 'HECTOLITRO'],
            ['id' => 'LEF', 'active' => 0, 'symbol' => 'LEF', 'description' => 'HOJA'],
            ['id' => 'SET', 'active' => 0, 'symbol' => 'SET', 'description' => 'JUEGO'],
            ['id' => 'KTM', 'active' => 0, 'symbol' => 'KTM', 'description' => 'KILOMETRO'],
            ['id' => 'MWH', 'active' => 0, 'symbol' => 'MWH', 'description' => 'MEGAWATT HORA'],
            ['id' => 'MTK', 'active' => 0, 'symbol' => 'MTK', 'description' => 'METRO CUADRADO'],
            ['id' => 'MTQ', 'active' => 0, 'symbol' => 'MTQ', 'description' => 'METRO CUBICO'],
            ['id' => 'UM', 'active' => 0, 'symbol' => 'UM', 'description' => 'MILLON DE UNIDADES'],
            ['id' => 'PR', 'active' => 0, 'symbol' => 'PR', 'description' => 'PAR'],
            ['id' => 'FTK', 'active' => 0, 'symbol' => 'FTK', 'description' => 'PIES CUADRADOS'],
            ['id' => 'FTQ', 'active' => 0, 'symbol' => 'FTQ', 'description' => 'PIES CUBICOS'],
            ['id' => 'RM', 'active' => 0, 'symbol' => 'RM', 'description' => 'RESMA'],
            ['id' => 'DR', 'active' => 0, 'symbol' => 'DR', 'description' => 'TAMBOR'],
            ['id' => 'STN', 'active' => 0, 'symbol' => 'STN', 'description' => 'TONELADA CORTA'],
            ['id' => 'LTN', 'active' => 0, 'symbol' => 'LTN', 'description' => 'TONELADA LARGA'],
            ['id' => 'YDK', 'active' => 0, 'symbol' => 'YDK', 'description' => 'YARDA CUADRADA']
        ];

        foreach ($data as $item) {
            DB::connection('tenant')->table('cat_unit_types')
                ->where('id', $item['id'])
                ->update([
                    'symbol' => $item['symbol'],
                    'description' => $item['description']
                ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    
    }
}
