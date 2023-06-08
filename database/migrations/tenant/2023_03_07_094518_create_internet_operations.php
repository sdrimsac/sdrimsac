<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternetOperations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internet_operations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description', 255);
            $table->decimal('total');
            $table->unsignedInteger('register_id');
            $table->enum('period', ['unique', 'monthly'])->default('unique');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->foreign('register_id')->references('id')->on('internet_register');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internet_operations');
    }
}
