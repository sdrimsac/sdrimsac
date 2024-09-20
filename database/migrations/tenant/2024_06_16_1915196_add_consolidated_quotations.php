<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConsolidatedQuotations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->boolean('consolidated')->default(false);
            $table->unsignedInteger('consolidated_id')->nullable();
            $table->foreign('consolidated_id')->references('id')->on('consolidated')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn('consolidated');
            $table->dropForeign(['consolidated_id']);
            $table->dropColumn('consolidated_id');
        });
    }
}
