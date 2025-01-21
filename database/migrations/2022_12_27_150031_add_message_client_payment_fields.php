<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

//2022_12_27_150031_add_message_client_payment_fields
class AddMessageClientPaymentFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_payments', function (Blueprint $table) {
            $table->longText('message_client_before_end')->nullable();
            $table->longText('message_client_after_end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_payments', function (Blueprint $table) {
            $table->dropColumn('message_client_before_end');
            $table->dropColumn('message_client_after_end');
        });
    }
}
