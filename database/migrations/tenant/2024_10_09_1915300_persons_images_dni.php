<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PersonsImagesDni extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->string('image_extra1')->nullable()->after('image');
            
            $table->string('image_extra2')->nullable()->after('image_extra1');
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
            $table->dropColumn([
                'image_extra1',
                'image_extra2',
            ]);
        });

    }
}