<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPromotionsDueTime extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::table('room_services', function (Blueprint $table) {
			$table->time('due_time')->nullable();
		});
		Schema::table('hotel_rent_item_services', function (Blueprint $table) {
			$table->date('date_take')->nullable();
			$table->boolean('was_due')->default(false);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		Schema::table('room_services', function (Blueprint $table) {
			$table->dropColumn('due_time');
		});
		Schema::table('hotel_rent_item_services', function (Blueprint $table) {
			$table->dropColumn('was_due');
			$table->dropColumn('date_take');
		});
	}
}
