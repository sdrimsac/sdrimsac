<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->date('date_payment')->nullable();
            $table->unsignedInteger('sale_note_id')->nullable();
            $table->string('type_payment')->default('Diario');
            $table->decimal('amount', 12, 4);
            $table->char('payment_method_type_id')->nullable();
            $table->integer('tasa')->default(0);
            $table->timestamps();
            $table->foreign('sale_note_id')->references('id')->on('sale_notes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
