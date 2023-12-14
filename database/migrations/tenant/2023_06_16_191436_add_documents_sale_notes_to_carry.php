<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocumentsSaleNotesToCarry extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('documents', function (Blueprint $table) {
			$table->boolean('to_carry')->default(false);
		});	

		Schema::table('sale_notes', function (Blueprint $table) {
			$table->boolean('to_carry')->default(false);
		});
	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('documents', function (Blueprint $table) {
			$table->dropColumn('to_carry');
		});	

		Schema::table('sale_notes', function (Blueprint $table) {
			$table->dropColumn('to_carry');
		});
		
	}
}
