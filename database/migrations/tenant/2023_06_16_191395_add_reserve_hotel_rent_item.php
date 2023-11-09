<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReserveHotelRentItem extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('hotel_rent_items', function (Blueprint $table) {
			$table->boolean('is_reserve')->default(false);
		});
	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
			
		Schema::table('hotel_rent_items', function (Blueprint $table) {
			$table->dropColumn('is_reserve');
		});
	
	}
}
