<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2025_02_18_100010_add_quotation_item_no_found_consolidated_documents
class ComandaOculto extends Migration
{

    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('nane_comand')->default(false);
        });    
    }

    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('name_comand');
        });
    }
}
