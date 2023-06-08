<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantAddStatusToBankAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('bank_accounts', function (Blueprint $table) {
        //     $table->tinyInteger('status')->default(1)->after('currency_type_id');
        // });
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bank_id');
            $table->string('description');
            $table->string('number');
            $table->string('currency_type_id');
            $table->tinyInteger('status')->default(1);
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->foreign('currency_type_id')->references('id')->on('cat_currency_types');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
