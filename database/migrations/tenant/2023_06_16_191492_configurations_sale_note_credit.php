<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConfigurationsSaleNoteCredit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('sale_note_credit_penalty')->default(false);
            $table->boolean('sale_note_credit_confirm')->default(false);
            $table->boolean('sale_note_credit_low_pay')->default(false);
            $table->boolean('sale_note_credit_edit')->default(false);
            $table->boolean('sale_note_credit_send_whatsapp')->default(false);
            $table->boolean('sale_note_credit_formats')->default(false);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('sale_note_credit_penalty');
            $table->dropColumn('sale_note_credit_confirm');
            $table->dropColumn('sale_note_credit_low_pay');
            $table->dropColumn('sale_note_credit_edit');
            $table->dropColumn('sale_note_credit_send_whatsapp');
            $table->dropColumn('sale_note_credit_formats');
        });
    
    }
}
