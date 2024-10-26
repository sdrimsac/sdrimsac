<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesMechanic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->string('description');
            $table->boolean('active')->default = true;
            $table->timestamps();
        });
        Schema::create('services_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('service_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->date("date_start")->nullable();
            $table->date("date_end")->nullable();
            $table->boolean('status')->nullable()->default(null);
            $table->timestamps();
            $table->foreign('service_id')->references('id')->on('services');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /* Schema::dropIfExists('services');
        Schema::dropIfExists('services_details'); */
        /* Schema::disableForeignKeyConstraints(); */
        Schema::dropIfExists('services_details');
        Schema::dropIfExists('services');
        /* Schema::enableForeignKeyConstraints(); */
    }
}
