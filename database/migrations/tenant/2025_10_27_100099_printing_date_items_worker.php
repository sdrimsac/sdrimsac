<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PrintingDateItemsWorker extends Migration
{

    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->decimal('promo_max_quantity', 10, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('promo_max_quantity');
        });
    }
}
