<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BanksAccounts extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->decimal('balance')->before('status')->default(0);
     
        });

        Schema::table('boxes', function (Blueprint $table) {
            $table->unsignedInteger('bank_account_id')->nullable();
            $table->string('bank_account_operation')->nullable();
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
            $table->dropColumn('balance');
         
        });
        Schema::table('boxes', function (Blueprint $table) {
            $table->dropColumn('bank_account_id');
            $table->dropColumn('bank_account_operation');
         
        });
     
    }
}
