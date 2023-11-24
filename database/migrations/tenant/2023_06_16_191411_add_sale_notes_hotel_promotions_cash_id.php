<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSaleNotesHotelPromotionsCashId extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('sale_notes_promotions', function (Blueprint $table) {
			$table->unsignedInteger('cash_id')->nullable();
			$table->foreign('cash_id')->references('id')->on('cash');
		});
	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		Schema::table('sale_notes_promotions', function (Blueprint $table) {
			$table->dropForeign(['cash_id']);
			$table->dropColumn('cash_id');
		});
	}
}
