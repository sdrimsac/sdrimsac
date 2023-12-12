<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderNoteSaleNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::table('sale_notes', function (Blueprint $table) {
            $table->unsignedInteger('order_note_id')->nullable()->after('document_id');
            $table->foreign('order_note_id')->references('id')->on('order_notes');
        });

       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
      

        if (Schema::hasColumn('sale_notes', 'order_note_id')) {
            Schema::table('sale_notes', function (Blueprint $table) {
                $table->dropForeign(['order_note_id']);
                $table->dropColumn('order_note_id');
            });
        }

   
    

     
    }
}
