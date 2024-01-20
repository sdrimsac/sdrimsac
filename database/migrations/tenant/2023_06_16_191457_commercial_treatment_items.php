<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CommercialTreatmentItems extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('commercial_treatment_items', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('item_id');
			$table->unsignedInteger('commercial_treatment_id');
			$table->decimal('amount');
			$table->boolean('active');
			$table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
			$table->foreign('commercial_treatment_id')->references('id')->on('commercial_treatments')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		Schema::dropIfExists('commercial_treatment_items');
		
	}
}
