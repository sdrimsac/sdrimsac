<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PromotionDocumentCustomersDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_document_customer_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('document_id');
            $table->unsignedInteger('sale_note_id');
            $table->unsignedInteger('promotion_customer_id');
            $table->decimal('total', 12, 2);
            $table->timestamps();
            $table->foreign('document_id')->references('id')->on('documents');
            $table->foreign('sale_note_id')->references('id')->on('sale_notes');
            $table->foreign('promotion_customer_id')->references('id')->on('promotion_document_customers');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotion_document_customer_detail');
    }
}
