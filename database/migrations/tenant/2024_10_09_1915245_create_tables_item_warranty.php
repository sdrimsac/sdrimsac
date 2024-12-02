<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//2024_10_09_1915240_add_user_id_inventory_kardex



class CreateTablesItemWarranty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_warranty', function (Blueprint $table) {
            $table->increments('id');
            $table->date('warranty_start_date')->nullable();
            $table->date('warranty_end_date');
            $table->unsignedInteger('sale_note_item_id')->nullable();
            $table->unsignedInteger('document_item_id')->nullable();
            $table->timestamps();
            $table->foreign('sale_note_item_id')->references('id')->on('sale_note_items');
            $table->foreign('document_item_id')->references('id')->on('document_items');
        });

    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_warranty');
    }
}
