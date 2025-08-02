<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ValidationDeliveryConfig extends Migration
{
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('delivery_caja')->default(false);
            $table->boolean('delivery_cocina')->default(false);
            $table->boolean('restaurant_delivery')->default(false);
        });
    }

    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('restaurant_delivery');
            $table->dropColumn('delivery_caja');
            $table->dropColumn('delivery_cocina');
        });
    }
}
