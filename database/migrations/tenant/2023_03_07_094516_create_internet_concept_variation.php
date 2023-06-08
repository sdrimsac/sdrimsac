<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternetConceptVariation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internet_concept_variation', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('concept_id');
            $table->string('description');
            $table->decimal('price');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->foreign('concept_id')->references('id')->on('internet_concept');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internet_concept_variation');
    }
}
