<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternetConceptOperation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internet_concept_operation', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('operation_id');
            $table->unsignedInteger('concept_id');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->foreign('operation_id')->references('id')->on('internet_operations');
            $table->foreign('concept_id')->references('id')->on('internet_concept_variation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internet_concept_operation');
    }
}
