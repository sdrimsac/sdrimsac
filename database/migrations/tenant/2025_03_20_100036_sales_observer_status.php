<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class  SalesObserverStatus extends Migration
{
    public function up()
    {
        Schema::table('sale_notes', function (Blueprint $table) {
            $table->string('observations')->nullable();
        });
    }

    public function down()
    {
        Schema::table('sale_notes', function (Blueprint $table) {
            $table->dropColumn('observations');
        });
    }
}
