<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class  ObserverItemsNew extends Migration
{
    public function up()
    {
        Schema::table('observations', function (Blueprint $table) {
            $table->unsignedInteger('item_id')->nullable();
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('observations', function (Blueprint $table) {
            $table->dropColumn('item_id');
        });
    }
}
