<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserSeries extends Migration
{

        
        public function up()
        {
            Schema::create('user_series', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('user_id');
                $table->unsignedInteger('serie_id');
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('serie_id')->references('id')->on('series');
            });
        }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_series');

    
    }
}
