<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_notes', function (Blueprint $table) {
            $table->string('type_payment',30)->default('Diario')->after('charges');
            $table->integer('num_cuota')->nullable()->after('charges');
            $table->decimal('amount',7,4)->nullable()->after('charges');
            $table->integer('month')->nullable()->after('charges');
            $table->text('additional_information')->nullable()->after('charges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_notes', function (Blueprint $table) {
            $table->dropColumn('type_payment');
            $table->dropColumn('num_cuota');
            $table->dropColumn('amount');
            $table->dropColumn('additional_information');
        });
    }
}
