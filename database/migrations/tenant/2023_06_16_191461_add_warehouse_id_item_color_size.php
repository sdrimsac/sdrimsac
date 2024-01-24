<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWarehouseIdItemColorSize extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('item_colors_sizes', function (Blueprint $table) {
			$table->unsignedInteger('warehouse_id')->nullable();
			$table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
		});


	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('item_colors_sizes', function (Blueprint $table) {
			$table->dropForeign(['warehouse_id']);
			$table->dropColumn('warehouse_id');
		});
		
		
		
	}
}
