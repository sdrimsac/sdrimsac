<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromocionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promociones', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('prom_clie_id');
            $table->unsignedInteger('prom_items_id');
            $table->integer('prom_cumulative_purchase')->default(0);
            $table->integer('prom_to_redeem')->default(0);
            $table->integer('prom_redeemed')->default(0);
            $table->timestamps();

            $table->foreign('prom_clie_id')->references('id')->on('persons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promociones');
    }
}
