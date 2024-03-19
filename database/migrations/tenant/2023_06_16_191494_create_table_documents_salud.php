<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDocumentsSalud extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('documents_salud', function (Blueprint $table) {
            $table->id();
            $table->date('date_of_issue');
            $table->date('date_of_charge');
            $table->string('file_name');
            $table->string('identifier');
            $table->string('status');
            $table->string('error')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents_salud');
    }
}
