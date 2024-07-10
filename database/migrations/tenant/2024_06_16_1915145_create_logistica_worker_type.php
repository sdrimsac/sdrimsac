<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLogisticaWorkerType extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$exist = DB::connection('tenant')->table('workers_type')->where('description', 'LOGISTICA')->exists();
		if (!$exist) {
			DB::connection('tenant')->table('workers_type')->insert([
				'description' => 'LOGISTICA',
				'active' => 0,
				'created_at' => now(),
				'updated_at' => now(),
			]);
		}


	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	
	}
}
