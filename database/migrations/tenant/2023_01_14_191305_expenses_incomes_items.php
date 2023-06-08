<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExpensesIncomesItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses_incomes_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unit_id');
            $table->string('detail');
            $table->timestamps();
            $table->foreign('unit_id')->references('id')->on('cat_unit_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('expenses_incomes_items');
    }
}
