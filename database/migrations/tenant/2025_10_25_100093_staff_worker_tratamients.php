<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StaffWorkerTratamients extends Migration
{
    public function up()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->boolean('is_staff')->default(false);
        });
    }

    public function down()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->dropColumn('is_staff');   
        });
    }
}
