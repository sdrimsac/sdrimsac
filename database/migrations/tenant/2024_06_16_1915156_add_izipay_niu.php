<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class AddIzipayNiu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('payment_method_types')->insert([
            'id' =>16,
            'description' =>  'TARJETA: IZYPAY',
            'has_card' =>  0,
            'charge' =>  null,
            'number_days' => null,
            'active' => 1,
        ]);
        DB::table('payment_method_types')->insert([
            'id' =>17,
            'description' =>  'TARJETA: OPENPAY',
            'has_card' =>  0,
            'charge' =>  null,
            'number_days' => null,
            'active' => 1,
        ]);
        DB::table('payment_method_types')->insert([
            'id' =>18,
            'description' =>  'TARJETA: NIUBIZ',
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
