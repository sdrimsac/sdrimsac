<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApiSunatToCompanies extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('soap_sunat_username', 20)->nullable();
            $table->string('soap_sunat_password', 20)->nullable();
            $table->string('api_sunat_id', 36)->nullable();
            $table->string('api_sunat_secret', 50)->nullable();
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
            $table->dropColumn('soap_sunat_username');
            $table->dropColumn('soap_sunat_password');
            $table->dropColumn('api_sunat_id');
            $table->dropColumn('api_sunat_secret');
        });
    }
}
