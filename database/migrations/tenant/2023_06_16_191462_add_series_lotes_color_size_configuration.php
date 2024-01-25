<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSeriesLotesColorSizeConfiguration extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('configurations', function (Blueprint $table) {
			$table->boolean('series_enabled')->default(true);
			$table->boolean('lots_enabled')->default(true);
			$table->boolean('color_size_enabled')->default(true);

		});


	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('configurations', function (Blueprint $table) {
			$table->dropColumn('series_enabled');
			$table->dropColumn('lots_enabled');
			$table->dropColumn('color_size_enabled');
		});
	}
}
