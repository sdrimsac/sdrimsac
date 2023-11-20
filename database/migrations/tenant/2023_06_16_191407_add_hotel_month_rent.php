<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHotelMonthRent extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tables',function(Blueprint $table){
				$table->decimal('month_price')->default(0);
		});

		Schema::table('hotel_rent_items',function (Blueprint $table){
			$table->boolean('is_month_rent')->default(false);
		});
		
	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('table',function(Blueprint $table){
				$table->dropColumn('month_price');
		});
		Schema::table('hotel_rent_item',function (Blueprint $table){
			$table->dropColumn('is_month_rent');
		});
	
	}
}
