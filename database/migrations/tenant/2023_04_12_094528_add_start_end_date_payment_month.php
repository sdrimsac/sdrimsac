<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartEndDatePaymentMonth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('internet_payment_month', function (Blueprint $table) {
            $table->date('end_date')->nullable()->after('year');
            $table->date('start_date')->nullable()->after('year');
            $table->enum('state', ['complete', 'incomplete'])->nullable()->after('year');
            $table->decimal('rest')->nullable()->after('year');
            $table->decimal('amount')->nullable()->after('year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('internet_payment_month', function (Blueprint $table) {
            $table->dropColumn("start_date");
            $table->dropColumn("end_date");
            $table->dropColumn("state");
            $table->dropColumn("rest");
            $table->dropColumn("amount");
        });
    }
}
