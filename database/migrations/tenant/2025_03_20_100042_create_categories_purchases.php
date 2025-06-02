<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesPurchases extends Migration
{
    public function up()
    {
        Schema::create('categogies_purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('item_id')->nullable();
            $table->string('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('categogies_purchases');
    }
}
