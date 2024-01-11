<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManufacturedRecords extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('manufactured_records', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('item_id');
			$table->integer('quantity')->default(0);
			$table->date('date_of_issue');
			$table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');

		});

	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('manufactured_records');
		
		
	}
}
