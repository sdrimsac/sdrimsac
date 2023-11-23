<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsAdvanceHotelRentDocument extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('hotel_rent_documents',function(Blueprint $table){
				$table->boolean('is_advance')->default(false);
		});

		
	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		Schema::table('hotel_rent_documents',function(Blueprint $table){
				$table->dropColumn('is_advance');
		});
	
	}
}
