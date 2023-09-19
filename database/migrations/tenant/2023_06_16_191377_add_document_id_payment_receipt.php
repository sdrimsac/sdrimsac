<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocumentIdPaymentReceipt extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->unsignedInteger('document_id')->nullable()->after('sale_note_payment_id');
            $table->unsignedInteger('document_payment_id')->nullable()->after('sale_note_payment_id');
     
        });

      

    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropColumn('document_id');
            $table->dropColumn('document_payment_id');
         
        });
     
     
    }
}
