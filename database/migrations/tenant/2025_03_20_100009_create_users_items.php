<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2025_03_20_100009_create_users_items
class CreateUsersItems extends Migration
{

    public function up()
    {
        Schema::create('users_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('item_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('item_id')->references('id')->on('items');
        });    
    }

    public function down()
    {
        Schema::dropIfExists('users_items');
    }
}
