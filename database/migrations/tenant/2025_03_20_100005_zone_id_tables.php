<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2025_02_18_100010_add_quotation_item_no_found_consolidated_documents
class ZoneIdTables extends Migration
{

    public function up()
    { 
        Schema::table('tables', function (Blueprint $table) {
            // Cambiar a unsignedBigInteger
            $table->unsignedBigInteger('zone_id')->nullable();
            // Definir la clave foránea correctamente
            $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');
        });  
    }

    public function down()
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->dropForeign(['zone_id']);
            $table->dropColumn('zone_id');
        });
    }
}
