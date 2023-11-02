<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceToTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tables', function (Blueprint $table) {
			$table->decimal('price', 12, 2)->default(0);
			$table->longText('description')->nullable()->after('number');
		});


	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tables', function (Blueprint $table) {
			$table->dropColumn('price');
			$table->dropColumn('description');
		
		});
		
		

	}
}
