<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandsFisicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('commands_fisico')->default(false)->nullable()->after('multiple_boxes');
         });
        Schema::table('ordens', function (Blueprint $table) {
            $table->string('commands_fisico',30)->default("")->nullable()->after('status');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configurations', function(Blueprint $table) {
            $table->dropColumn('commands_fisico');
       });

       Schema::table('ordens', function(Blueprint $table) {
        $table->dropColumn('commands_fisico');
   });
    }
}
