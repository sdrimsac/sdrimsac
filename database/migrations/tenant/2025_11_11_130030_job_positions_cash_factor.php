<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class JobPositionsCashFactor extends Migration
{
    public function up()
    {
        Schema::create('job_positions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('sueldo_base', 8, 2)->default(1.00);
            $table->decimal('factor_diario', 5, 2)->default(1.00);
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_positions');
    }
}
