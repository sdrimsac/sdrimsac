<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2025_02_18_100010_add_quotation_item_no_found_consolidated_documents
class InicialiceReportCash extends Migration
{

    public function up()
    {
        Schema::create('cash_init_stock', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('cash_id');
            $table->unsignedInteger('item_id');
            $table->decimal('initial_stock', 12, 4)->default(0);
            $table->timestamps();
            $table->foreign('cash_id')->references('id')->on('cash');
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cash_init_stock');
    }
}
