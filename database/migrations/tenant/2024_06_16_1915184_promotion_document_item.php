<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PromotionDocumentItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_document_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('promotion_document_id');
            $table->unsignedInteger('item_id');
            $table->decimal('quantity', 12, 2);
            $table->foreign('promotion_document_id')->references('id')->on('promotion_documents');
            $table->foreign('item_id')->references('id')->on('items');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotion_document_items');
    }
}
