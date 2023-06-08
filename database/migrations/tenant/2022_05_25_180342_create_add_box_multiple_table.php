<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddBoxMultipleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('multiple_boxes')->nullable()->after('recreat_document');
        });
    }

    public function down()
    {
       Schema::table('configurations', function(Blueprint $table) {
            $table->dropColumn('multiple_boxes');
       });
    }
}
