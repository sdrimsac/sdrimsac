<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WeigthConsolidated extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consolidated', function (Blueprint $table) {

            $table->decimal('weight', 12, 2)->default(0)->after('date_of_issue');

            
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consolidated', function (Blueprint $table) {
            $table->dropColumn('weight');
        });
          
    } 
}
