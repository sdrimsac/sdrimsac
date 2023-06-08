<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstablishmentTable extends Migration
{
    
    public function up()
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->unsignedInteger('establishment_id')->after('status_table_id')->nullable();
            $table->foreign('establishment_id')->references('id')->on('establishments')->onDelete('cascade');
        });
    }

  
    public function down()
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->dropColumn('establishment_id');
        });
    }
}
