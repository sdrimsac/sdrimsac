<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStockFileCash extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('cash', function (Blueprint $table) {
			$table->string('stock_file')->nullable();
		});	
	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cash', function (Blueprint $table) {
			$table->dropColumn('stock_file');
		
		});
		
	}
}
