<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsCleaningTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tables', function (Blueprint $table) {
			$table->boolean('is_cleaning')->default(false);
			$table->timestamp('cleaning_start_date')->nullable();
		});


	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tables', function (Blueprint $table) {
			$table->dropColumn('is_cleaning');
			$table->dropColumn('cleaning_start_date');
		});
		
		

	}
}
