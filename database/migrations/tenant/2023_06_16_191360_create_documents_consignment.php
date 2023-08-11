<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsConsignment extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consignment_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('consignment_id');
            $table->unsignedInteger('document_id')->nullable();
            $table->unsignedInteger('sale_note_id')->nullable();
            $table->foreign('consignment_id')->references('id')->on('consignments');
            $table->foreign('document_id')->references('id')->on('documents');
            $table->foreign('sale_note_id')->references('id')->on('sale_notes');
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
        Schema::table('consignment_documents', function (Blueprint $table) {
            $table->dropForeign(['consignment_id']);
            $table->dropForeign(['document_id']);
            $table->dropForeign(['sale_note_id']);
        });
        Schema::dropIfExists('consignment_documents');
     
     
    }
}
