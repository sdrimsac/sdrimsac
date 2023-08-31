<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrientationA5 extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('show_image_a5')->default(false);
            $table->boolean('a5_orientation')->default(false);
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->string('a5_image')->default(false);
        });

    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('show_image_a5');
            $table->dropColumn('a5_orientation');
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('a5_image');
        });
     
    }
}
