<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2025_02_18_100010_add_quotation_item_no_found_consolidated_documents
class   SeccionUser extends Migration
{

    public function up()
    {
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('session_id');
            $table->string('user_agent');
            $table->timestamps();
        
            /* $table->foreign('user_id')->references('id')->on('users'); */
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });  
    }

    public function down()
    {
        Schema::dropIfExists('user_sessions');
    }
}
