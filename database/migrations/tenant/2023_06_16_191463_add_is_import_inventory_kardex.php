<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsImportInventoryKardex extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('inventory_kardex', function (Blueprint $table) {
			$table->boolean('is_import_excel')->default(false);

		});


	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('inventory_kardex', function (Blueprint $table) {
			$table->dropColumn('is_import_excel');
		});
		
	}
}
