<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientZoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_zones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->boolean('active')->default(1);
            $table->timestamps();
        });

        Schema::table('persons', function (Blueprint $table) {
            $table->unsignedInteger('client_zone_id')->nullable();
            $table->foreign('client_zone_id')->references('id')->on('client_zones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_zone');

        Schema::table('persons', function (Blueprint $table) {
            $table->dropColumn("client_zone_id");
            $table->dropForeign(["client_zone_id"]);
        });
    }
}
