<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertMethodPayment extends Migration
{
    public function up()
    {
        DB::table('payment_method_types')->insert([
            'id' => 19,
            'description' => 'Culqui',
            'has_card' => 0, 
            'charge' => null,
            'number_days' => 0,
            'active' => 1,  
        ]);
    }

    public function down()
    {
        DB::table('payment_method_types')->where('id', 19)->delete();
    }
}
