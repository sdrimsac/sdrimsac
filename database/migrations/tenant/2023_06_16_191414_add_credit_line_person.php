<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreditLinePerson extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::table('persons', function (Blueprint $table) {
			$table->boolean('has_credit_line')->default(false);
			$table->decimal('credit_line', 12, 2)->default(0);
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		Schema::table('persons', function (Blueprint $table) {
			$table->dropColumn('has_credit_line');
			$table->dropColumn('credit_line');
		});

	}
}
