<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleNotesHotelPromotions extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('sale_notes_promotions', function (Blueprint $table) {
			$table->id();
			$table->unsignedInteger('hotel_rent_item_service_id');
			$table->unsignedInteger('sale_note_id');
			$table->timestamps();
			$table->foreign('hotel_rent_item_service_id')->references('id')->on('hotel_rent_item_services');
			$table->foreign('sale_note_id')->references('id')->on('sale_notes');
		});
	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('sale_notes_promotions');
	}
}
