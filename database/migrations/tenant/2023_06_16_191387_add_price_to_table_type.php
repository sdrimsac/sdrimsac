<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPriceToTableType extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasColumn("table_types", "price")) {
			Schema::table('table_types', function (Blueprint $table) {
				$table->decimal('price', 12, 2)->after('name')->default(0);
			});
		}

	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		if (Schema::hasColumn("table_types", "price")) {
			Schema::table('table_types', function (Blueprint $table) {
				$table->dropColumn('price');
			});
		}

	}
}
