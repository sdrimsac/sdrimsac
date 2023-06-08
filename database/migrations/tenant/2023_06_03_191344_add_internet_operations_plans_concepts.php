<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInternetOperationsPlansConcepts extends Migration
{
    
    public function up()
    {
        Schema::table('internet_operations', function (Blueprint $table) {
            $table->json('plan')->nullable();
            $table->json('concepts')->nullable();
        });
    }

  
    public function down()
    {
        Schema::table('internet_operations', function (Blueprint $table) {
            $table->dropColumn('plan');
            $table->dropColumn('concepts');
        });
    }
}
