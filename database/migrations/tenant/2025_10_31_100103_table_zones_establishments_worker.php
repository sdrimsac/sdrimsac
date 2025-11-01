<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TableZonesEstablishmentsWorker extends Migration
{

    public function up(): void
    {
        Schema::table('zones', function (Blueprint $table) {
            $table->unsignedInteger('establishment_id')->nullable();

            $table->foreign('establishment_id')->references('id')->on('establishments')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('zones', function (Blueprint $table) {
            $table->dropForeign(['establishment_id']);
            $table->dropColumn('establishment_id');
        });
    }
}
