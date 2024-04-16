<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class NoteNulleableAffectedDocument extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->unsignedInteger('affected_document_id')->nullable()->change();
        });
        }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
        
    }

}
