<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCashesPrincipal extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cash_income_principal',function(Blueprint $table){
			$table->increments('id');
			$table->unsignedInteger('cash_principal_id');
			$table->unsignedInteger('cash_id');
			$table->longText('comment')->nullable();
			$table->decimal('amount', 12, 2);
			$table->tinyInteger('status')->default(1);
			$table->boolean('active')->default(true);
			$table->timestamps();
			$table->foreign('cash_id')->references('id')->on('cash');
			$table->foreign('cash_principal_id')->references('id')->on('cash');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		Schema::dropIfExists('cash_income_principal');
		
		
		
	}
}
