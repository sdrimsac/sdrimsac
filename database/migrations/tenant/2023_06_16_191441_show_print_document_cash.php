<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ShowPrintDocumentCash extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('configurations', function (Blueprint $table) {
			$table->boolean('print_document_cash')->default(false);
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
			$table->dropColumn('print_document_cash');
		});	

	
		
	}
}
