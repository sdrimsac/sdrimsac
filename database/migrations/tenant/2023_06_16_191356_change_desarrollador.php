<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeDesarrollador extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('desarrollador')->where('id', 1)->update(['name' => 'SDRIMSAC SOLUTIONS']);

        


    
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
