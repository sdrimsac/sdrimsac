<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ItemNewTableResumen extends Migration
{
    public function up()
    {
        Schema::create('item_sales_summary', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('item_id');
            $table->decimal('total_sales', 10, 2);
            $table->decimal('total_quantity', 10, 2);
            $table->timestamps();
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_sales_summary');
    }
}
