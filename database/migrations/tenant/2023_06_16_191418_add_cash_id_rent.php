<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCashIdRent extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('hotel_rents', function (Blueprint $table) {
			$table->unsignedInteger('cash_id')->nullable()->after('sale_note_id');
			$table->foreign('cash_id')->references('id')->on('cash')->onDelete('cascade');
		});	
	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		Schema::table('hotel_rents', function (Blueprint $table) {
			$table->dropForeign(['cash_id']);
			$table->dropColumn('cash_id');
		});
	}
}
