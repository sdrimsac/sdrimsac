<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
//2024_10_09_1915306_create_imgs_table

class CreateImgsTable extends Migration
{
    public function up()
    {

        Schema::create('table_images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('table_id');
            $table->string('image_path');
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->foreign('table_id')
                  ->references('id')
                  ->on('tables')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('table_images');
    }
}