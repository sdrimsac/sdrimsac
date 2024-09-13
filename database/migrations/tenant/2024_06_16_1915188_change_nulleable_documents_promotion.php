<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNulleableDocumentsPromotion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotion_document_customer_detail', function (Blueprint $table) {
            $table->unsignedInteger('sale_note_id')->nullable()->change();
            $table->unsignedInteger('document_id')->nullable()->change();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    
    }
}
