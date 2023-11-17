<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditList extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::table('configurations',function (Blueprint $table){
			$table->boolean('credit_list')->default(false);
		});
		Schema::table('persons',function (Blueprint $table){
			$table->boolean('credit_list')->default(false);
		});
		Schema::create('credit_lists', function (Blueprint $table) {
			$table->id();
			$table->unsignedInteger('orden_id');
			$table->unsignedInteger('customer_id');
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('establishment_id');
			$table->foreign('orden_id')->references('id')->on('ordens');
			$table->foreign('customer_id')->references('id')->on('persons');
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('establishment_id')->references('id')->on('establishments');
			$table->string('observation')->nullable();
			$table->boolean('paid')->default(false);
			$table->timestamps();
			});
	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('configurations',function (Blueprint $table){
			$table->dropColumn('credit_list');
		});
		Schema::table('persons',function (Blueprint $table){
			$table->dropColumn('credit_list');
		});
		Schema::dropIfExists('credit_lists');
	}
}
