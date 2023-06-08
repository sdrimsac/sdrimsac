<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddDocumentPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->boolean('notpayment')->nullable()->default(false)->after('observation');
         });
         Schema::table('sale_notes', function (Blueprint $table) {
            $table->boolean('notpayment')->nullable()->default(false)->after('paid');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('notpayment');
        });
        Schema::table('sale_notes', function (Blueprint $table) {
            $table->dropColumn('notpayment');
        });
    }
}
