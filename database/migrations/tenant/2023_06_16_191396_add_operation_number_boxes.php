<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOperationNumberBoxes extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('boxes', function (Blueprint $table) {
			$table->string('operation_number')->nullable();
		});
	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
			
		Schema::table('boxes', function (Blueprint $table) {
			$table->dropColumn('operation_number');
		});
	
	}
}
