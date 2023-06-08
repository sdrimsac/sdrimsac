<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddIncomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boxes', function (Blueprint $table) {
            $table->boolean('incomes')->default(false)->nullable()->after('state');
            $table->boolean('expenses')->default(false)->nullable()->after('state');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boxes', function(Blueprint $table) {
            $table->dropColumn('incomes');
            $table->dropColumn('expenses');
      });
    }
}
