<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2025_02_18_100010_add_quotation_item_no_found_consolidated_documents
class AddQuotationItemNoFoundConsolidatedDocuments extends Migration
{

    public function up()
    {
        Schema::table('quotation_items', function (Blueprint $table) {
            $table->boolean('no_found_consolidated_documents')->default(false);
        });

        
    }

    public function down()
    {
        Schema::table('quotation_items', function (Blueprint $table) {
            $table->dropColumn('no_found_consolidated_documents');
        });
    }
}
