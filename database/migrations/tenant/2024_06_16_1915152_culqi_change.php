<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CulqiChange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('configurations', function (Blueprint $table) {
        //     //
            
        //     $table->boolean('yape')->default(false);
        //     $table->boolean('culqi')->default(false);
        //     $table->boolean('izipay')->default(false);
        //     $table->boolean('openpay')->default(false);
        //     $table->boolean('nubiz')->default(false);
        //     $table->boolean('plin')->default(false);
            
        // });
        DB::connection('tenant')->table('configurations')->update([
            'yape' => true,
            'culqi' => true,
            'izipay' => true,
            'openpay' => true,
            'nubiz' => true,
            'plin' => true
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // //
        // Schema::table('configurations', function (Blueprint $table) {
        //     $table->dropColumn('yape');
        //     $table->dropColumn('culqi');
        //     $table->dropColumn('izipay');  
        //     $table->dropColumn('openpay');
        //     $table->dropColumn('nubiz');
        //     $table->dropColumn('plin');
        // });  
    }
}