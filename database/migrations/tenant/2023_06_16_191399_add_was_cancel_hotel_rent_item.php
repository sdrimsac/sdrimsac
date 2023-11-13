<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWasCancelHotelRentItem extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('hotel_rents', function (Blueprint $table) {
			$table->boolean('was_cancel')->default(false);
		});
		Schema::table('hotel_rent_items', function (Blueprint $table) {
			$table->boolean('was_cancel')->default(false);
		});
	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		Schema::table('hotel_rent', function (Blueprint $table) {
			$table->dropColumn('was_cancel');
		});

		Schema::table('hotel_rent_items', function (Blueprint $table) {
			$table->dropColumn('was_cancel');
		});
	}
}
