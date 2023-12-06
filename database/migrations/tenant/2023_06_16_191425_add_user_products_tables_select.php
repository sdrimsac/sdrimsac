<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserProductsTablesSelect extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('users', function (Blueprint $table) {
			$table->unsignedInteger('warehouse_product_id')->nullable();
			$table->unsignedInteger('establishment_table_id')->nullable();
			$table->foreign('establishment_table_id')->references('id')->on('establishments')->onDelete('cascade');
			$table->foreign('warehouse_product_id')->references('id')->on('warehouses')->onDelete('cascade');
	
		});	
	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function (Blueprint $table) {
			$table->dropForeign(['establishment_table_id']);
			$table->dropForeign(['warehouse_product_id']);
			$table->dropColumn('establishment_table_id');
			$table->dropColumn('warehouse_product_id');
		
		});
		
	}
}
