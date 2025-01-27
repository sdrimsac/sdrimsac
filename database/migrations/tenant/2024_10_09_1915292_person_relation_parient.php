<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PersonRelationParient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('persons', function (Blueprint $table) {

            $table->unsignedInteger('parient_id')->nullable();
            $table->foreign('parient_id')->references('id')->on('person_parient');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('persons', function (Blueprint $table) {
            // Eliminar la clave foránea y la columna parient_id
            $table->dropForeign(['parient_id']);
            $table->dropColumn('parient_id');
        });
        /* Schema::dropIfExists('persons'); */
    }
}
