<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConfigurationAddFooterText extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('configurations', function (Blueprint $table) {
			$table->text('footer_text')->nullable();
		});


	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('configurations', function (Blueprint $table) {
			$table->dropColumn('footer_text');
		});
		
		
		
	}
}
