<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollegePayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('college_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('document_id');
            $table->unsignedInteger('register_id');
            $table->enum('type', ['complete', 'incomplete'])->default('complete');
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->foreign('document_id')->references('id')->on('documents');
            $table->foreign('register_id')->references('id')->on('college_registers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('college_payments');
    }
}
