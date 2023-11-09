<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreateServiceAllWarehouse extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('configurations', function (Blueprint $table) {
			$table->boolean('create_service_all_warehouse')->default(false);
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
			$table->dropColumn('create_service_all_warehouse');
		});
	
	}
}
