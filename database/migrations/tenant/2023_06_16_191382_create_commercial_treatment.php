<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommercialTreatment extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercial_treatments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->boolean('is_amount')->default(true);
            $table->boolean('active')->default(true);
        
        });
    
        Schema::table('items', function (Blueprint $table) {
            $table->boolean('has_commercial_treatment')->default(true);
        });
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      
       
        Schema::dropIfExists('commercial_treatments');
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('has_commercial_treatment');
         
        });
    }
}
