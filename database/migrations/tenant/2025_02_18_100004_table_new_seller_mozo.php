<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableNewSellerMozo extends Migration
{
    public function up()
    {
        Schema::create('seller_mozo', function (Blueprint $table) {
            $table->increments('id');
            /* $table->unsignedInteger('specialty_id'); */
            $table->string('name');
            $table->string('document');
            /* $table->unsignedInteger('document_type_id')->after('document'); */
            $table->string('telephone')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('establishment_id')->nullable();
            $table->string('active')->nullable();
            $table->timestamps();

            /* $table->foreign('document_type_id')
                  ->references('id')
                  ->on('specialties')
                  ->onDelete('cascade'); */
        });
    }

    public function down()
    {
        Schema::dropIfExists('seller_mozo');
    }
}
