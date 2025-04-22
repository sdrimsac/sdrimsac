<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2025_02_18_100010_add_quotation_item_no_found_consolidated_documents
class   ComissionShopBox extends Migration
{

    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->decimal('commission', 8, 2)->default(0);
        });    
    }

    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('commission');
        });
    }
}
