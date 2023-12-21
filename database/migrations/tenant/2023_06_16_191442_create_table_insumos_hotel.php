<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableInsumosHotel extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('insumos_hotels', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('item_id');

			$table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
		});

	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('insumos_hotels');
		
		
	}
}
