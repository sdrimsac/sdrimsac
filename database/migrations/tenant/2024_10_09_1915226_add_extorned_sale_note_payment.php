<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtornedSaleNotePayment extends Migration
{
    public function up()
    {
        Schema::table('sale_note_payments', function (Blueprint $table) {
            $table->boolean('extorned')->default(false);
        });
    }

    public function down()
    {
        Schema::table('sale_note_payments', function (Blueprint $table) {
            $table->dropColumn('extorned');
        });
    }
}