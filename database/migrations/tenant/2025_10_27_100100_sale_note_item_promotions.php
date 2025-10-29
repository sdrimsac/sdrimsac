<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SaleNoteItemPromotions extends Migration
{

    public function up()
    {
        Schema::create('sale_note_item_promotions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sale_note_item_id')->nullable();
            $table->unsignedInteger('document_item_id')->nullable();
            $table->unsignedInteger('item_id')->nullable();
            $table->decimal('quantity', 10, 2)->nullable();
            $table->timestamps();
            $table->foreign('sale_note_item_id')->references('id')->on('sale_note_items')->onDelete('cascade');
            $table->foreign('document_item_id')->references('id')->on('document_items')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sale_note_item_promotions');
    }
}
