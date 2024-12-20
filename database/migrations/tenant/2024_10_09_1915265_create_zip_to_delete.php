<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//2024_10_09_1915265_create_zip_to_delete

class CreateZipToDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zip_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_number');
            $table->string('file_zip');
            $table->boolean('is_downloaded')->default(false);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zip_files');
    
    }
}
