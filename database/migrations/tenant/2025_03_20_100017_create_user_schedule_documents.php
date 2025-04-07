<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2025_03_20_100017_create_user_schedule_documents
class   CreateUserScheduleDocuments extends Migration
{

    public function up()
    {
        Schema::create('appointments_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_schedule_appointments');
            $table->foreign('user_schedule_appointments')->references('id')->on('user_schedule_appointments');
            $table->unsignedInteger('document_id')->nullable();
            $table->foreign('document_id')->references('id')->on('documents');
            $table->unsignedInteger('sale_note_id')->nullable();
            $table->foreign('sale_note_id')->references('id')->on('sale_notes');
            $table->timestamps();
        });    
    }

    public function down()
    {
        Schema::dropIfExists('appointments_documents');
    }
}
