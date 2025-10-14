<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertDateDocumentPayments extends Migration
{
    public function up()
    {
        Schema::table('document_payments', function (Blueprint $table) {
            $table->dateTime('date_of_issue_payment')->nullable();
            $table->string('method')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

        });
    }


    public function down()
    {
        Schema::table('document_payments', function (Blueprint $table) {
            $table->dropColumn('date_of_issue_payment');
            $table->dropColumn('method');
            $table->dropColumn('user_id');
            $table->dropForeign(['user_id']);
        });
    }
}
