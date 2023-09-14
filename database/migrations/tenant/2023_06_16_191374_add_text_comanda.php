<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTextComanda extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('text_comanda')->default(false);
            $table->string('text_one')->nullable();
            $table->string('text_two')->nullable();
        });

      

    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('text_comanda');
            $table->dropColumn('text_one');
            $table->dropColumn('text_two');
        });
     
     
    }
}
