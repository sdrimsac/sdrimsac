<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConfigMethodsReportCash extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('report_cash_methods')->default(false);
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
            $table->dropColumn('report_cash_methods');
        });
        
    }
}