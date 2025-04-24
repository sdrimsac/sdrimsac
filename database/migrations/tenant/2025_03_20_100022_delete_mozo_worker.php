<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2025_02_18_100010_add_quotation_item_no_found_consolidated_documents
class   DeleteMozoWorker extends Migration
{

    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('delete_mozo')->default(true);
            $table->boolean('category_deslay')->default(false);
            $table->boolean('created_items')->default(false);
        });    
    }

    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('delete_mozo');
            $table->dropColumn('category_deslay');
            $table->dropColumn('created_items');
        });
    }
}
