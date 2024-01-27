<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryKardexDetail extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inventory_kardex_detail',function(Blueprint $table){
			$table->increments('id');
			$table->unsignedInteger('inventory_kardex_id');
			$table->string('detail');
			$table->foreign('inventory_kardex_id')->references('id')->on('inventory_kardex')->onDelete('cascade');
		});


	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('inventory_kardex_detail');
	}
}
