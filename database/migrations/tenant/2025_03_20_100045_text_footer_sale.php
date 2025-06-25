<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TextFooterSale extends Migration
{
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->string('text_sale')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('text_sale');
        });
    }
}
