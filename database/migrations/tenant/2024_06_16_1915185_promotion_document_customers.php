<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PromotionDocumentCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_document_customers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('promotion_document_id');
            $table->unsignedInteger('customer_id');
            $table->decimal('acc_total', 12, 2);
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('promotion_document_customers');
    }
}
