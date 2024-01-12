<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnQuantityIntToDecimalsItemSets extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('item_sets', function (Blueprint $table) {
			$table->decimal('quantity', 12, 4)->change();
		});


	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('item_sets', function (Blueprint $table) {
			$table->integer('quantity')->change();
		});
		
		
		
	}
}
