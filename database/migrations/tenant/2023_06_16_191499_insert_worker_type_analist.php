<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertWorkerTypeAnalist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('tenant')->table('workers_type')->insert([
            [ 'description' => 'ANALISTA', 'active' => 0],
        ]);
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        DB::connection('tenant')->table('workers_type')->where('description', 'ANALISTA')->delete();
        
    }
}
