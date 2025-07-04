<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DefaultTrueRestaurant extends Migration
{
    public function up()
    {
        Schema::table('seller_mozo', function (Blueprint $table) {
            $table->boolean('active')->default(true)->change();
        });
    }
    
    public function down()
    {
        Schema::table('seller_mozo', function (Blueprint $table) {
            $table->boolean('active')->nullable()->default(null)->change();
          
        });
    }
}
