<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellers extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('document');
            $table->string('telephone')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('establishment_id')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    
      
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      
       
        Schema::dropIfExists('sellers');
     
    }
}
