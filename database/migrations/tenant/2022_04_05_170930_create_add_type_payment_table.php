<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddTypePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('payment_method_types')->insert([
            'id' =>11,
            'description' =>  'YAPE',
            'has_card' =>  0,
            'charge' =>  null,
            'number_days' => null,
            'active' => 1,
        ]);
        DB::table('payment_method_types')->insert([
            'id' =>12,
            'description' =>  'PLIN',
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
