<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReceiptAddNumCuota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('receipts', function (Blueprint $table) {
        
            $table->integer('num_cuota')->nullable()->after('date_of_issue');
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
            $table->dropColumn('num_cuota');
        });
    
    }
}
