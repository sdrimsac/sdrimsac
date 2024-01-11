<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManufacturedRecordsItems extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('manufactured_record_items', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('manufactured_record_id');
			$table->unsignedInteger('item_id');
			$table->integer('quantity')->default(0);

			$table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
			$table->foreign('manufactured_record_id')->references('id')->on('manufactured_records')->onDelete('cascade');

		});

	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('manufactured_records_items');
		
		
	}
}
