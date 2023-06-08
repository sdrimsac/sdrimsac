<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSaleNoteIdPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('college_payments', function (Blueprint $table) {
            $table->unsignedInteger('sale_note_id')->nullable()->after('document_id');
            $table->unsignedInteger('document_id')->nullable()->change();
            $table->foreign('sale_note_id')->references('id')->on('sale_notes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('college_payments', function (Blueprint $table) {
            $table->dropColumn("sale_note_id");
        });
    }
}
