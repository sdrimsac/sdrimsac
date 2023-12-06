<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class LogisticWorkerType extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		DB::connection('tenant')
			->table('workers_type')
			->insert(
				[
					[
						'description' => 'LOGISTICA',
						'active' => 0,
					],
				
				]
			);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		DB::connection('tenant')
			->table('workers_type')
			->whereIn('description', ['LOGISTICA'])
			->delete();
	}
}
