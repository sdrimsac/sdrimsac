<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ImageYapePrecuenta extends Migration
{
    public function up()
    {
        Schema::table('establishments', function (Blueprint $table) {
            $table->string('image_yape')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('establishments', function (Blueprint $table) {
            $table->dropColumn('image_yape');
          
        });
    }
}
