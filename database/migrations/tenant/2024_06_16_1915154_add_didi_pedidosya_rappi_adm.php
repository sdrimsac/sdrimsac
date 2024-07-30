<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class AddDidiPedidosyaRappiAdm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('payment_method_types')->insert([
            'id' =>13,
            'description' =>  'DIDI FOODS',
            'has_card' =>  0,
            'charge' =>  null,
            'number_days' => null,
            'active' => 1,
        ]);
        DB::table('payment_method_types')->insert([
            'id' =>14,
            'description' =>  'PEDIDOS YA',
            'has_card' =>  0,
            'charge' =>  null,
            'number_days' => null,
            'active' => 1,
        ]);
        DB::table('payment_method_types')->insert([
            'id' =>15,
            'description' =>  'RAPPI',
            'has_card' =>  0,
            'charge' =>  null,
            'number_days' => null,
            'active' => 1,
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
    }
}
