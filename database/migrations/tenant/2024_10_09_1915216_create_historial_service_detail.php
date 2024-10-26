<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistorialServiceDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('historial_service_details',function (Blueprint $table) {
        $table->unsignedInteger('historial_id');
        $table->unsignedInteger('services_detail_id');
        $table->foreign('historial_id')->references('id')->on('historial');
        $table->foreign('services_detail_id')->references('id')->on('services_details');
       });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('historial_service_details');
    }
}
