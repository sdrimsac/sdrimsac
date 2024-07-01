<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddDetraction035 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    
        DB::table('cat_detraction_types')->insert([
            [
                'id' => '035',
                'description' => 'Bienes exonerados del IGV',
                'percentage' => 1.5,
                'operation_type_id' => '1001',
                'active' => true,
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('cat_detraction_types')->where('id', '035')->delete();

        
    }
}
