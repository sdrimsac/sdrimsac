<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternetPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internet_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('document_id')->nullable();
            $table->unsignedInteger('sale_note_id')->nullable();
            $table->unsignedInteger('operation_id');
            $table->enum('type', ['complete', 'incomplete'])->default('complete');
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->foreign('document_id')->references('id')->on('documents');
            $table->foreign('sale_note_id')->references('id')->on('sale_notes');
            $table->foreign('operation_id')->references('id')->on('internet_operations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internet_payments');
    }
}
