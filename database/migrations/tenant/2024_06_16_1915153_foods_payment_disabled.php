<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FoodsPaymentDisabled extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            //
            
            $table->boolean('didi')->default(false);
            $table->boolean('rappi')->default(false);
            $table->boolean('pedidosya')->default(false);
        
            
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('didi');
            $table->dropColumn('rappi');
            $table->dropColumn('pedidosya');
        });
        
    }
}