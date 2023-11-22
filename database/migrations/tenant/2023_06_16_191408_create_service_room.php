<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRoom extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('room_services',function(Blueprint $table){
				$table->increments('id');
				$table->string('name');
				$table->string('description')->nullable();
				$table->boolean('has_items')->default(false);
				$table->boolean('active')->default(true);
				$table->timestamps();
		});

		Schema::create('item_room_services',function(Blueprint $table){
				$table->increments('id');
				$table->unsignedInteger('room_service_id');
				$table->unsignedInteger('food_id');
				$table->integer('quantity')->default(1);
				$table->timestamps();
				$table->foreign('room_service_id')->references('id')->on('room_services');
				$table->foreign('food_id')->references('id')->on('foods');
		});

		Schema::create('table_room_services',function(Blueprint $table){
				$table->increments('id');
				$table->unsignedInteger('table_id');
				$table->unsignedInteger('room_service_id');
				$table->boolean('active')->default(true);
				$table->timestamps();
				$table->foreign('table_id')->references('id')->on('tables');
				$table->foreign('room_service_id')->references('id')->on('room_services');
		});

		Schema::create('hotel_rent_item_services',function (Blueprint $table){
			$table->increments('id');
			$table->unsignedInteger('hotel_rent_item_id');
			$table->unsignedInteger('room_service_id');
			$table->integer('quantity')->default(1);
			$table->string('code',150)->nullable();
			$table->boolean('active')->default(true);
			$table->timestamps();
			$table->foreign('hotel_rent_item_id')->references('id')->on('hotel_rent_items');
			$table->foreign('room_service_id')->references('id')->on('room_services');
		});
	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('hotel_rent_item_services');
		Schema::dropIfExists('item_room_services');
		Schema::dropIfExists('table_room_services');
		Schema::dropIfExists('room_services');
	
	}
}
