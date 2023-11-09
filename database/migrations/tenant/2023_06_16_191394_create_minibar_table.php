<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMinibarTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('minibar_tables', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('table_id')->nullable();
			$table->string('description')->nullable();
			$table->boolean('active')->default(true);
			$table->foreign('table_id')->references('id')->on('detail_tables');
		});

		Schema::create('minibar_table_items',function (Blueprint $table){
			$table->increments('id');
			$table->unsignedInteger('minibar_table_id');
			$table->unsignedInteger('food_id');
			$table->decimal('price', 12, 2);
			$table->integer('quantity');
			$table->boolean('active')->default(true);
			$table->foreign('minibar_table_id')->references('id')->on('minibar_tables');
			$table->foreign('food_id')->references('id')->on('foods');
		});
		
	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	
		Schema::dropIfExists('minibar_table_items');
		Schema::dropIfExists('minibar_table');
	}
}
