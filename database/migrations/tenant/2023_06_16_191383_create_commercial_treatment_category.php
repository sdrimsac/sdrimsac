<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommercialTreatmentCategory extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercial_treatment_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_item_id');
            $table->unsignedInteger('commercial_treatment_id');
            $table->decimal('amount')->default(0);
            $table->boolean('active')->default(true);
        
        });

    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      
       
        Schema::dropIfExists('commercial_treatment_categories');
       
    }
}
