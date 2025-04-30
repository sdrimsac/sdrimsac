<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2025_02_18_100010_add_quotation_item_no_found_consolidated_documents
class   ItemLotsStatusActive extends Migration
{

    public function up()
    {
        Schema::table('item_lots_group', function (Blueprint $table) {
            $table->boolean('status')->default(true);
        });    
    }

    public function down()
    {
        Schema::table('item_lots_group', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
