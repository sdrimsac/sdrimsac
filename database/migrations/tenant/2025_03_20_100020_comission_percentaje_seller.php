<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2025_02_18_100010_add_quotation_item_no_found_consolidated_documents
class ComissionPercentajeSeller extends Migration
{

    public function up()
    {
        Schema::table('sellers', function (Blueprint $table) {
            
            $table->decimal('commission_percentage', 5, 2)->default(0)->after('active');
          
        });    
    }

    public function down()
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn('commission_percentage');

        });
    }
}
