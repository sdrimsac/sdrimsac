<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//add_items_promotion_received_customer

class AddItemsPromotionReceivedCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('promotion_received')) {
            Schema::create('promotion_received', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('promotion_document_customer_id');
                $table->unsignedInteger('item_id');
                $table->integer('quantity');
                $table->unsignedInteger('document_id')->nullable();
                $table->unsignedInteger('sale_note_id')->nullable();
                $table->timestamps();
                $table->foreign('promotion_document_customer_id')->references('id')->on('promotion_document_customers');
                $table->foreign('document_id')->references('id')->on('documents');
                $table->foreign('sale_note_id')->references('id')->on('sale_notes');
                $table->foreign('item_id')->references('id')->on('items');
            });
        }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotion_received');
    }
}
