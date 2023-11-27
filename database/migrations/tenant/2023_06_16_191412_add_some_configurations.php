<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeConfigurations extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('configurations', function (Blueprint $table) {
			$table->boolean('auth_discount')->default(false);
			$table->integer('time_manteniment')->default(45);
			$table->boolean('show_expenses_incomes_caja')->default(true);
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
			$table->dropColumn('auth_discount');
			$table->dropColumn('time_manteniment');
			$table->dropColumn('show_expenses_incomes_caja');
		
		});
	}
}
