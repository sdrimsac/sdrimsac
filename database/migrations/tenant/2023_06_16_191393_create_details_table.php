<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDetailsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detail_tables', function (Blueprint $table) {
			$table->increments('id');
			$table->string('description');
			$table->boolean('active')->default(true);
		});
		$details = [
			['description' => "TV MIRAY SMART 50 PLG", 'active' => 1],
			['description' => "AIRE ACONDICIONADO", 'active' => 1],
			['description' => "ROPERO", 'active' => 1],
			['description' => "MESA Y 2 SILLAS", 'active' => 1],
			['description' => "SECADORA DE CABELLO", 'active' => 1],
			['description' => "BAÑERA", 'active' => 1],
			['description' => "CAMA QUEEN", 'active' => 1],
			['description' => "TV SMART 50 PLG", 'active' => 1],
			['description' => "TINA", 'active' => 1],
			['description' => "SILLON", 'active' => 1],
			['description' => "TV MIRAY 32 PLG", 'active' => 1],
			['description' => "CAMA DE PLAZA Y ½", 'active' => 1],
			['description' => "CAMA MATRIMONIAL (2 PLAZAS)", 'active' => 1],
			['description' => "TV AOC 32 PLG", 'active' => 1],
			['description' => "VENTILADOR", 'active' => 1],
			['description' => "TV HIUNDAY", 'active' => 1],
			['description' => "TV DAEWOO", 'active' => 1],
		];
		DB::connection('tenant')
			->table('detail_tables')
			->insert($details);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::connection('tenant')
			->table('detail_tables')
			->delete();
		Schema::dropIfExists('detail_tables');
	}
}
