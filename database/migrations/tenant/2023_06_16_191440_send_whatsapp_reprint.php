<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SendWhatsappReprint extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('configurations', function (Blueprint $table) {
			$table->boolean('reprint_whatsapp')->default(false);
			$table->boolean('product_cash')->default(false);
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
			$table->dropColumn('reprint_whatsapp');
			$table->dropColumn('product_cash');
		});	

	
		
	}
}
