<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

//
class AddTypeEstilista extends Migration
{

    public function up()
    {
        DB::table('workers_type')->insert([
            ['description' => 'ESTILISTA', 'active' => 0]
        ]);
    }

    public function down()
    {
        DB::table('workers_type')->where('id', 6)->delete();
    }
}
