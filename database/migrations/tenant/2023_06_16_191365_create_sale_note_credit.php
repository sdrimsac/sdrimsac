<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleNoteCredit extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_note_credits', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cash_id')->nullable();
            $table->unsignedInteger('sale_note_id')->nullable();
            $table->foreign('cash_id')->references('id')->on('cash');
            $table->foreign('sale_note_id')->references('id')->on('sale_notes');
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
      
        Schema::dropIfExists('sale_note_credits');
     
     
    }
}
