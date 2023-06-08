<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEditProductPos extends Migration
{
    
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('edit_product_pos')->default(false);
            $table->boolean('print_incomes_expenses')->default(false);
        });
    }

  
    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('edit_product_pos');
            $table->dropColumn('print_incomes_expenses');
        });
    }
}
