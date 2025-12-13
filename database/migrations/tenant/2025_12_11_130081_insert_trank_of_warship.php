<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertTrankOfWarship extends Migration
{
    public function up()
    {
        DB::table('workers_type')->insert([
            ['description' => 'GESTION', 'active' => false],
        ]);
    }

    public function down()
    {
        Schema::table('workers_type', function (Blueprint $table) {
            $table->whereIn('description', ['GESTION'])->delete();
        });
    }
}
