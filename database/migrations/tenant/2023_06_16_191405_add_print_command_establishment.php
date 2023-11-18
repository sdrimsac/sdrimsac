<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrintCommandEstablishment extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::table('conf_establishment',function (Blueprint $table){
			$table->boolean('print_command')->default(true);
		});
		
	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('conf_establishment',function (Blueprint $table){
			$table->dropColumn('print_command');
		});
	
	}
}
