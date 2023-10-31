<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddStatusTableJustVacated extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		

		DB::connection('tenant')
		->table('status_table')
		->insert([
			'id' => 5,
			'description'  => 'Recién desocupado',
			'active' => true,
		]);

	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::connection('tenant')
		->table('status_table')
		->where('id', 5)
		->delete();
		
		

	}
}
