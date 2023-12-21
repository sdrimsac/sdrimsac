<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableInsumosHotelItem extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('insumos_hotel_items', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('insumos_hotel_id');
			$table->unsignedInteger('hotel_rent_item_id');
			$table->integer('quantity')->default(0);

			$table->foreign('insumos_hotel_id')->references('id')->on('insumos_hotels')->onDelete('cascade');
			$table->foreign('hotel_rent_item_id')->references('id')->on('hotel_rent_items')->onDelete('cascade');

		});

	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('insumos_hotel_items');
		
		
	}
}
