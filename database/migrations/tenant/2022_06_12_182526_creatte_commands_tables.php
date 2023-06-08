<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatteCommandsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('configurations', function (Blueprint $table) {
        //     $table->boolean('print_commands')->default(false)->nullable()->after('multiple_boxes');
        // });
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('print_commands')->default(false)->nullable()->after('multiple_boxes');
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
            $table->dropColumn('print_commands');
       });
    }
}
