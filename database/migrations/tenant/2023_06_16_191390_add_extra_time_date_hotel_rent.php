<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraTimeDateHotelRent extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('hotel_rent_items', function (Blueprint $table) {
			$table->decimal('extra_time', 12, 2)->default(0);
			$table->date('checkout_date_estimated')->nullable()->after('checkin_date');
			$table->time('checkout_time_estimated')->nullable()->after('checkin_time');
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
			$table->dropColumn('extra_time');
			$table->dropColumn('checkout_date_estimated');
			$table->dropColumn('checkout_time_estimated');
		
		});
		
		

	}
}
