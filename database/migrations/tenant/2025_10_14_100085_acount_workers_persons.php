<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AcountWorkersPersons extends Migration
{
    public function up()
    {
        Schema::table('establishments', function (Blueprint $table) {
            $table->boolean('account_workers')->default(false);
        });
    }


    public function down()
    {
        Schema::table('establishments', function (Blueprint $table) {
            $table->dropColumn('account_workers');
        });
    }
}
