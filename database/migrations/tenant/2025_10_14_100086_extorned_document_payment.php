<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ExtornedDocumentPayment extends Migration
{
    public function up()
    {
        Schema::table('document_payments', function (Blueprint $table) {
            $table->boolean('extorned')->default(false);
            $table->string('number_method')->nullable();
        });
    }

    public function down()
    {
        Schema::table('document_payments', function (Blueprint $table) {
            $table->dropColumn('extorned');
            $table->dropColumn('number_method');
        });
    }
}
