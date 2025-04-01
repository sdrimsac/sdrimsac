<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2025_02_18_100010_add_quotation_item_no_found_consolidated_documents
class   InsertReason extends Migration
{

    public function up()
    {
        Schema::table('ordens', function (Blueprint $table) {
            $table->string('reason')->nullable();
        });    
    }

    public function down()
    {
        Schema::table('ordens', function (Blueprint $table) {
            $table->dropColumn('reason');
        });
    }
}
