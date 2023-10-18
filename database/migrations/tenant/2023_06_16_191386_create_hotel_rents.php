<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelRents extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasColumn("persons", "sex")) {
			Schema::table('persons', function (Blueprint $table) {
				$table->enum('sex', ['M', 'F'])->nullable();
			});
		}

		Schema::create('hotel_rents', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('customer_id');
			$table->unsignedInteger('establishment_id');
			$table->unsignedInteger('user_id');
			$table->json('customer');
			$table->string('observation', 250)->nullable();
			$table->string('payment_type', 10)->nullable();
			$table->string('payment_number_operation', 20)->nullable();
			$table->string('payment_status', 10);
			$table->decimal('advance', 12,2);
			$table->decimal('total', 12, 2);
			$table->boolean('paid')->default(false);
			$table->unsignedInteger('document_id')->nullable();
			$table->unsignedInteger('sale_note_id')->nullable();
			$table->timestamps();
			$table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
			$table->foreign('sale_note_id')->references('id')->on('sale_notes')->onDelete('cascade');
			$table->foreign('customer_id')->references('id')->on('persons')->onDelete('cascade');
			$table->foreign('establishment_id')->references('id')->on('establishments')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});

		Schema::create('hotel_rent_items', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('hotel_rent_id');
			$table->unsignedInteger('table_id');
			$table->integer('duration')->default(1);
			$table->integer('quantity_persons')->default(1);
			$table->string('payment_status');
			$table->date('checkin_date')->nullable();
			$table->time('checkin_time')->nullable();
			$table->date('checkout_date')->nullable();
			$table->time('checkout_time')->nullable();
			$table->timestamps();
			$table->foreign('hotel_rent_id')->references('id')->on('hotel_rents')->onDelete('cascade');
			$table->foreign('table_id')->references('id')->on('tables')->onDelete('cascade');
		});
		Schema::create('hotel_rent_item_person', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('hotel_rent_item_id');
			$table->unsignedInteger('person_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		if (Schema::hasColumn("persons", "sex")) {
			Schema::table('persons', function (Blueprint $table) {
				$table->dropColumn('sex');
			});
		}


		Schema::dropIfExists('hotel_rent_item_person');
		Schema::dropIfExists('hotel_rent_items');
		Schema::dropIfExists('hotel_rents');
	}
}
