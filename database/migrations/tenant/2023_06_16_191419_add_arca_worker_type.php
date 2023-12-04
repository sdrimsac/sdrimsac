<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddArcaWorkerType extends Migration
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
						'description' => 'ARCA',
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
			->whereIn('description', ['ARCA'])
			->delete();
	}
}
