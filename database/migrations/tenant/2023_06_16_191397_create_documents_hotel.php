<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsHotel extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('hotel_rent_documents', function (Blueprint $table) {
			$table->id();
			$table->unsignedInteger('hotel_rent_id');
			$table->unsignedInteger('document_id')->nullable();
			$table->unsignedInteger('sale_note_id')->nullable();
			$table->timestamps();
			$table->foreign('hotel_rent_id')->references('id')->on('hotel_rents');
			$table->foreign('document_id')->references('id')->on('documents');
			$table->foreign('sale_note_id')->references('id')->on('sale_notes');
		});
	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('hotel_rent_documents');
	}
}
