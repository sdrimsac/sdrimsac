<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ByPointsPromotion extends Migration
{
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('promotion_pdf')->default(false);
        });
    }

    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('promotion_pdf');
        });
    }
}
