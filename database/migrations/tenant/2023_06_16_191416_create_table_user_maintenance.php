<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUserMaintenance extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('table_user_maintenance',function(Blueprint $table){
			$table->increments('id');
			$table->unsignedInteger('table_id');
			$table->unsignedInteger('user_id');
			$table->string('type',50);
			$table->string('init_comment',500)->nullable();
			$table->string('finish_comment',500)->nullable();
			$table->timestamp('init_time')->nullable();
			$table->timestamp('estimated_finish_time')->nullable();
			$table->timestamp('finish_time')->nullable();
			$table->tinyInteger('status')->default(1);
			$table->boolean('active')->default(true);
			$table->timestamps();
			$table->foreign('table_id')->references('id')->on('tables');
			$table->foreign('user_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		Schema::dropIfExists('table_maintenance');
		
		
	}
}
