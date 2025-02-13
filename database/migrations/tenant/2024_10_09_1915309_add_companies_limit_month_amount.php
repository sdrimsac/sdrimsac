<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2024_10_09_1915309_add_companies_limit_month_amount

class AddCompaniesLimitMonthAmount extends Migration
{
    /**
     * Run the migrations.

     *
     * @return void
     */

    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->decimal('limit_month_amount',10,2)->default(0);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'limit_month_amount',
            ]);
        });
    }
}
