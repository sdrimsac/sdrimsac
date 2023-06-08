<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPayDateCredit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('internet_register', function (Blueprint $table) {
            $table->date('pay_date')->nullable()->after('date');
            $table->decimal('credit')->nullable()->after('person_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('internet_register', function (Blueprint $table) {
            $table->dropColumn("pay_date");
            $table->dropColumn("credit");
        });
    }
}
