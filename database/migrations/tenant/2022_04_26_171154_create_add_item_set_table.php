<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddItemSetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_sets', function (Blueprint $table) {
            $table->decimal('sale_unit_price',12,4)->default(0)->nullable()->after('individual_item_id');
            $table->integer('quantity')->default(0)->nullable()->after('individual_item_id');    
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('add_item_set');
    }
}
