<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreditLineHotelRentItem extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('hotel_rent_items', function (Blueprint $table) {
			$table->decimal('credit_line', 12, 2)->default(0);
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
			$table->dropColumn('credit_line');
		});	
	}
}
