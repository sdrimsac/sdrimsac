<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewQuantityLigths extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('vehiculos', 'quantiy_front_lights')) {
            Schema::table('vehiculos', function (Blueprint $table) {
                $table->dropColumn('quantiy_front_lights');
            });
        }
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