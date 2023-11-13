<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimeToCleanTimeToLeave extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('configurations', function (Blueprint $table) {
			$table->integer('time_to_clean')->default(45);
			$table->integer('alarm_to_end')->default(15);
			$table->time('time_to_enter')->default('6:00:00');
			$table->time('time_to_leave')->default('12:00:00');
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
			$table->dropColumn('time_to_clean');
			$table->dropColumn('time_to_leave');
			$table->dropColumn('time_to_enter');
			$table->dropColumn('alarm_to_end');
		});
	
	}
}
