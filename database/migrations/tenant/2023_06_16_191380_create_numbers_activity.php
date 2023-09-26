<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumbersActivity extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('numbers_activity', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');
        
        });
    
      
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      
       
        Schema::dropIfExists('numbers_activity');
     
    }
}
