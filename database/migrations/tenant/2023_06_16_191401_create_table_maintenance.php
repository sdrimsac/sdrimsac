<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMaintenance extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('table_maintenance', function (Blueprint $table) {
			$table->id();
			$table->unsignedInteger('table_id');
			$table->unsignedInteger('table_status_id');
			$table->timestamp('start_time')->nullable();
			$table->timestamp('end_time')->nullable();
			$table->boolean('active')->default(true);
			
		});
	
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
