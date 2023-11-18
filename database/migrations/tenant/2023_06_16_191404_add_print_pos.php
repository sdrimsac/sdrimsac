<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrintPos extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::table('configurations',function (Blueprint $table){
			$table->boolean('print_in_pos')->default(false);
		});
		
	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('configurations',function (Blueprint $table){
			$table->dropColumn('print_in_pos');
		});
	
	}
}
