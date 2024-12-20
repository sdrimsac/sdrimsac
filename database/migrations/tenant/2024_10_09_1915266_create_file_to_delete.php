<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//2024_10_09_1915265_create_file_to_delete

class CreateFileToDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_to_delete', function (Blueprint $table) {
            $table->string('file_path');
            $table->unsignedInteger('zip_id');
            $table->foreign('zip_id')->references('id')->on('zip_files');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files_to_delete');
    
    }
}
