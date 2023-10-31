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

		Schema::table('ordens',function (Blueprint $table){
			$table->unsignedInteger('hotel_rent_item_id')->nullable();
			$table->foreign('hotel_rent_item_id')->references('id')->on('hotel_rent_items')->onDelete('cascade');
		});

	
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
		Schema::table('ordens',function (Blueprint $table){
			$table->dropForeign(['hotel_rent_item_id']);
			$table->dropColumn('hotel_rent_item_id');
		});

	}
}
