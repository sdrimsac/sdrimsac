<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ItemsColorsSizes extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('item_colors_sizes', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('item_id');
			$table->string('color');
			$table->string('size');
			$table->decimal('stock');
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
		
		Schema::dropIfExists('item_colors_sizes');
		
	}
}
