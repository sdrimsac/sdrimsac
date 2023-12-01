<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddCleanMaintenance extends Migration
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
						'description' => 'LIMPIEZA',
						'active' => 0,
					],
					[
						'description' => 'MANTENIMIENTO',
						'active' => 0,
					]
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
			->whereIn('description', ['LIMPIEZA', 'MANTENIMIENTO'])
			->delete();
	}
}
