<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DocumentSaleNoteSellers extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->unsignedInteger('seller_id')->nullable();
        });

        Schema::table('sale_notes', function (Blueprint $table) {
            $table->unsignedInteger('seller_id')->nullable();
        });

    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('seller_id');
        });
        Schema::table('sale_notes', function (Blueprint $table) {
            $table->dropColumn('seller_id');
        });
     
    }
}
