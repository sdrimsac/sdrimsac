<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddPriceConfigurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('refresh_price_sales')->default(false)->nullable();
            });
            DB::table('configurations')->insert([
                'send_auto' => false,
                'locked_emission' => false,
                'locked_tenant' =>  false,
                'locked_users' =>  false,
                'limit_documents' =>  false,
                'limit_users' =>  false,
              //  'plan' => json_encode($plan),
                'date_time_start' =>  date('Y-m-d H:i:s'),
                'recreat_document'=>  0,
                'delete_document'=>  0,
                'show_restriction'=>  0,
                'show_quotations'=>  0,
                'config_system_env' =>false
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('refresh_price_sales');
        });
    }
}
