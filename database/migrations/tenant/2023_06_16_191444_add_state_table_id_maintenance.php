<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStateTableIdMaintenance extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('table_user_maintenance', function (Blueprint $table) {
			
			$table->integer('state_table_id')->nullable()->after('finish_time');



		});

	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		Schema::table('table_user_maintenance', function (Blueprint $table) {
			
			$table->dropColumn('state_table_id');

		});
		
	}
}
