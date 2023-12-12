<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderNoteDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->unsignedInteger('order_note_id')->nullable()->after('sale_note_id');
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
        //si existe la columna order_note_id en documents, sale_notes y dispatches
        //se elimina la columna y la llave foranea
        if (Schema::hasColumn('documents', 'order_note_id')) {
            Schema::table('documents', function (Blueprint $table) {
                $table->dropForeign(['order_note_id']);
                $table->dropColumn('order_note_id');
            });
        }

     
    

     
    }
}
