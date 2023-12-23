<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreditSaleNoteCash extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('configurations', function (Blueprint $table) {

			$table->boolean('sale_note_credit_cash')->default(false);

		});

	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		Schema::table('configurations', function (Blueprint $table) {
			
			$table->dropColumn('sale_note_credit_cash');
		});
		
	}
}
