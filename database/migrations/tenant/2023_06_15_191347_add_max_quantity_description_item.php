<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaxQuantityDescriptionItem extends Migration
{

    public function up()
    {


        Schema::table('items', function (Blueprint $table) {
            $table->string('max_quantity_description')->nullable()
                ->after('max_quantity');
        });
    }


    public function down()
    {


        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('max_quantity_description');
        });
    }
}
