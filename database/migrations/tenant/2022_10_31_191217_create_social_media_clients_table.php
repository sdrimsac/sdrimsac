<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialMediaClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_media_clients', function (Blueprint $table) {
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('social_media_id');
            $table->foreign('client_id')->references('id')->on('persons');
            $table->foreign('social_media_id')->references('id')->on('social_medias');

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
        Schema::dropIfExists('social_media_clients');
    }
}
