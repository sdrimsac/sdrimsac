<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VerMozoDocument extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seller_mozo', function (Blueprint $table) {
            $table->unsignedInteger('document_type_id')->after('document');
        });

      

    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seller-mozo', function (Blueprint $table) {
            $table->dropColumn('document_type_id');
        });
    }
}

